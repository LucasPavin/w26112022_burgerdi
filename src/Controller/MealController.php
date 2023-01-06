<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Notice;
use App\Form\MealType;
use App\Form\NoticeType;
use App\Form\SearchType;
use App\Model\SearchData;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MealRepository;
use App\Repository\NoticeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Post\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MealController extends AbstractController
{
    /**
     * This controller display all meal
     *  
     * @param MealRepository $repository
     * @return Response
     */
    #[Route('/plats', name: 'app_meal', methods:['GET', 'POST'])]
    public function index(MealRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $meal = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            //De mettre la request query à getInt
            $searchData->page = $request->query->getInt('page', 1);

            $mealsSearch = $repository->findBySearch($searchData);

            return $this->render("pages/meal/index.html.twig", [
                "form" => $form->createView(),
                "meals" => $mealsSearch
            ] );
        }

        return $this->render('pages/meal/index.html.twig', [
            'form' => $form->createView(),
            'meals' => $meal
        ]);
    }

    /**
     * This controller for create meal
     * 
     */
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/plats/creation', 'meal.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { 
            $meal = $form->getData();

            
            $manager->persist($meal);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le plat a été inséré avec succès!'
            );

            return $this->redirectToRoute('app_meal');

        } 
        // else {
        //     $this->addFlash(
        //         'warning',
        //         'Le plat n\'a pas été inséré !'
        //     );
        // }



        return $this->render('pages/meal/createMeal.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * This controller is for edit a meal 
     * 
     */
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/plats/modification/{id}', name:'meal.edit', methods:['GET', 'POST'])]
    public function editMeal(Meal $meal, Request $request, EntityManagerInterface $manager): Response {

        $form = $this->createForm(MealType::class, $meal);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $meal = $form->getData();
            $manager->persist($meal);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le plat a bien été modifié avec succès !'
            );

            return $this->redirectToRoute('app_meal');
        }

        return $this->render('pages/meal/editMeal.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * This controller is for delete a meal
     * 
     */
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/plats/suppression/{id}', name:'meal.delete', methods:['GET'])]
    public function deleteMeal(Meal $meal, Request $request, EntityManagerInterface $manager): Response {
        if(!$meal) {

            $this->addFlash(
                'warning',
                'Le plat n\'a pas été trouvé !'
             );
            return $this->redirectToRoute('app_meal');
        }
        $manager->remove($meal);
        $manager->flush();


        $this->addFlash(
            'success',
            'Le plat a été supprimé avec succès !'
         );
 
         return $this->redirectToRoute('app_meal');
    }

    #[Route('/plats/{id}', name: 'meal.see', methods:['GET', 'POST'])]
    public function see(Meal $meal, Request $request, NoticeRepository $noticeRepository, EntityManagerInterface $manager): Response 
    {
        $notice = new Notice();
        $form = $this->createForm(NoticeType::class, $notice);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // We tell him that the user is the connected user and that the meal is the one on the page
            $notice->setUser($this->getUser())
                ->setMeal($meal);
            // We will come and test if the user has not already voted
            $existing_notice = $noticeRepository->findOneBy([
                'user' => $this->getUser(),
                'meal' => $meal
            ]);
            /** If $existing_notice is null we persist the data in database
             *  Else 
            */
            if(!$existing_notice){
                $manager->persist($notice);
            } else {
                $existing_notice->setRating(
                    $form->getData()->getRating()
                );
                $existing_notice->setComment(
                    $form->getData()->getComment()
                );
            }
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre vote a bien été pris en compte, nous vous remercions.'
            );
            // If all is well, redirect to the same route
            return $this->redirectToRoute('meal.see', ['id' => $meal->getId()]);
        }

        return $this->render('pages/meal/meal.html.twig', [
            'meal' => $meal,
            'notice' => $notice,
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Entity\Notice;
use App\Form\MealType;
use App\Form\NoticeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\MealRepository;
use App\Repository\NoticeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MealController extends AbstractController
{
    /**
     * This controller display all meal
     *  
     * @param MealRepository $repository
     * @return Response
     */
    #[Route('/plats', name: 'app_meal', methods:['GET'])]
    public function index(MealRepository $repository): Response
    {
        $meals = $repository->findAll();

        return $this->render('pages/meal/index.html.twig', [
            'meals' => $meals
        ]);
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
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller for create meal
     * 
     */
    #[Route('/plats/creation', name:'meal.new', methods:['GET', 'POST'])]
    public function newMeal(Request $request, EntityManagerInterface $manager): Response{

        $meals = new Meal();
        $form = $this->createForm(MealType::class, $meals);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $meals = $form->getData();
            $manager->persist($meals);
            $manager->flush();

            $this->addFlash(
                'success',
                'Le plat a été inséré avec succès!'
            );

            return $this->redirectToRoute('app_meal');
        } else {
            $this->addFlash(
                'warning',
                'Le plat n\'a pas été inséré !'
            );
        }



        return $this->render('pages/meal/createMeal.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * This controller is for edit a meal 
     * 
     */
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

}

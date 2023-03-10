<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends AbstractController
{
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/dashboard/categories', name: 'app_category')]
    public function index( CategoryRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $paginator->paginate(
            $repository->findAll(), /* query all meals result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );
        
        
        $repository->findAll();

        return $this->render('pages/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/categories/publier', name:'category.new', methods:['GET', 'POST'])] 
    public function createCategory(EntityManagerInterface $manager, Request $request) : Response {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $category = $form->getData();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                'Création de la catégorie réussite !'
            );

            return $this->redirectToRoute('app_category');

        }
        return $this->render('pages/category/createCategory.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * This controller is use for edit one category
     */
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/categories/modification/{id}', name:'category.edit', methods:['GET', 'POST'])]
    public function editCategory(Category $category, EntityManagerInterface $manager, Request $request) : Response {

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            
            $category = $form->getData();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash(
                'success',
                'Modification de la catégorie !'
            );

            return $this->redirectToRoute('app_category');
        }

        return $this->render('pages/category/editcategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * This controller is used for delete one editCategory
     * 
     */
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/categories/suppression/{id}', name:'category.delete', methods:['GET', 'POST'])]
    public function deleteCategory(Category $category, EntityManagerInterface $manager, Request $request) : Response {

        if(!$category){
            $this->addFlash(
                'warning',
                'Aucune categorie n\'a été trouvé !'
            );
            return $this->redirectToRoute('app_category');
        }
        $manager->remove($category);
        $manager->flush();

        $this->addFlash(
           'success',
           'La catégorie a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_category');
    }
}
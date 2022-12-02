<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category')]
    public function index( CategoryRepository $repository ): Response
    {
        $categories = $repository->findAll();

        return $this->render('pages/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
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
                'Création de la catégorie !'
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
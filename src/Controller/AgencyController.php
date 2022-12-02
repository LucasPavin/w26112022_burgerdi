<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Form\AgencyType;
use Symfony\Component\Form\FormTypeInterface;
use App\Repository\AgencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AgencyController extends AbstractController
{
    #[Route('/agency', name: 'app_agency')]
    public function index(AgencyRepository $repository): Response
    {
        $agencies = $repository->findAll();
    
        return $this->render('pages/agency/agency.html.twig', [
            'agencies' => $agencies
        ]);
    }

    /**
     * This controller show a form which create an agency
     */
    #[Route('/agency/create', 'agency.new', methods:['GET', 'POST'])]
    public function new( Request $request, EntityManagerInterface $manager) : Response {

        $agency = new Agency();
        $form = $this->createForm(AgencyType::class, $agency);

        $form->handleRequest($request);
        //Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) { 
            // On récupère les éléments du formulaire dans la variable $agency
            $agency = $form->getData();
            // Dire à Doctrine que nous voulons sauvegarder un restaurant (pas encore de requêtes)
            $manager->persist($agency);
            // exécute la requête ( INSERT INTO )
            $manager->flush();

            $this->addFlash(
                'success',
                'Le restaurant a bien été inséré !'
            );

            return $this->redirectToRoute('app_agency');

        } else {
            $this->addFlash(
                'alert',
                'L\'insertion a échoué !'
            );
        }
 
        return $this->render('pages/agency/createAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller show a form which edit an agency
     * 
     * You can use 2 methods : The first you pass in params of the function (AgencyRepository $repository, int $id) the repository and a id, or you can paramsConverter just pass in params this (Agency $agency)
     * paramsConverter => https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
     * 
     */
    #[Route('/agency/edit/{id}', 'agency.edit', methods:['GET', 'POST'])]
    public function editAgency(Agency $agency, Request $request, EntityManagerInterface $manager) : Response 
    {
        // $agency = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(AgencyType::class, $agency);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            // On récupère les éléments du formulaire dans la variable $agency
            $agency = $form->getData();
            // Dire à Doctrine que nous voulons sauvegarder un restaurant (pas encore de requêtes)
            $manager->persist($agency);
            // exécute la requête ( INSERT INTO )
            $manager->flush();

            $this->addFlash(
                'success',
                'Le restaurant a bien été modifié avec succès !'
            );

            return $this->redirectToRoute('app_agency');

        } else {
            $this->addFlash(
                'alert',
                'La modification a échoué !'
            );
        }

        return $this->render('pages/agency/editAgency.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/agency/delete/{id}', 'agency.delete', methods:['GET'])]
    public function deleteAgency(EntityManagerInterface $manager, Agency $agency, Request $request): Response  
    {
        if(!$agency){
            $this->addFlash(
                'warning',
                'Le restaurant n\'a pas été trouvé !'
             );
            return $this->redirectToRoute('app_agency');
        }
        $manager->remove($agency);
        $manager->flush();

        $this->addFlash(
           'success',
           'Le restaurant a été supprimé avec succès !'
        );

        return $this->redirectToRoute('app_agency');
    }
}

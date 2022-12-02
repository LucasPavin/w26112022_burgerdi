<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login', methods:["GET", 'POST'])]
    public function login(): Response
    {
        return $this->render('pages/login/login.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
}

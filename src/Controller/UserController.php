<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    // #[Security()]
    #[Route('/dashboard/edition-information/{id}', name: 'user.edit', methods:['GET', 'POST'])]
    /**
     * This controller allow us to edit user's profile
     * @param User $user
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

        /**
         * Permet de vérifier si la personne connectée n'est pas une autre personne
         */
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }
        if($this->getUser() !== $user){
            return $this->redirectToRoute('app_meal');
        }
        // Fin de la vérification

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())){
                $user = $form->getData();
                $manager->persist($user);
                $manager->flush();
    
                $this->addFlash(
                    'Success',
                    'Les informations de votre compte ont été modifié.'
                );
    
                return $this->redirectToRoute('user.dashboard', ['id' => $user->getId()]);
            } else {
                $this->addFlash(
                    'Warning',
                    'Le mot de passe est incorrecte.'
                );
            }  
        }
        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // #[Security("is_granted('ROLE_USER','ROLE_ADMIN') and user === getUser()")]
    #[Route('/dashboard/edition-mot-de-passe/{id}', name:'user.edit.password', methods:['GET', 'POST'])]
    public function editPassword(User $user, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager ) : Response 
    {
        if(!$this->getUser()){ return $this->redirectToRoute('security.login');    }
        if($this->getUser() !== $user){ return $this->redirectToRoute('app_meal');
        }

        $form = $this->createForm(UserPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['plainPassword'])) {
                $user->setUpdatedAt(new \DateTimeImmutable());
                $user->setPlainPassword(
                    $form->getData()['newPassword']
                );

                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );
                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('user.dashboard', ['id' => $user->getId()]);
            } else {
                $this->addFlash(
                    'Warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }
        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
        // #[Security("is_granted('ROLE_USER','ROLE_ADMIN') and user === getUser()")]
    #[Route('/dashboard/{id}', name:'user.dashboard', methods:['GET', 'POST'])]
    public function dashboard(User $user ) : Response 
    {
        if(!$this->getUser()){ return $this->redirectToRoute('security.login');    }
        if($this->getUser() !== $user){ return $this->redirectToRoute('app_meal'); }

        return $this->render('pages/user/dashboard.html.twig');
    }
}

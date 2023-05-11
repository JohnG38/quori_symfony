<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    #[Route('/user/{id}', name: 'profile_user')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function userProfile(UserRepository $user): Response
    {
        $currentUser = $this->getUser();
        if($currentUser === $user) {
            return $this->redirectToRoute('current_user_profile');
        }

        return $this->render('user/profile.html.twig');
    }

    #[Route('/user', name: 'current_user_profile')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function currentUserProfile(): Response
    {
        return $this->render('user/profile.html.twig');
    }

}

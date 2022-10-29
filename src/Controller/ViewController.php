<?php

namespace App\Controller;

use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ViewController extends AbstractController
{
    #[Route('/', name: 'app_login')]
    public function index(PartnerRepository $repoPartner, AuthenticationUtils $authenticationUtils): Response
    {
        $partner = $repoPartner->findAll();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('view/login.html.twig', [
            'controller_name' => 'ViewController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}

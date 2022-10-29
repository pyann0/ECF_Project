<?php

namespace App\Controller;

use App\Repository\PartnerRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ViewController extends AbstractController
{

    #[Route('/', name: 'app_home')]
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
    #[Route('/login', name: 'app_login', methods: ['GET'])]
    public function login()
    {
        return $this->redirectToRoute('app_home');
    }


    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    
}

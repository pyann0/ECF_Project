<?php

namespace App\Controller;

use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
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

    #[IsGranted('ROLE_USER')]
    #[Route('/partenaire', name: 'app_partner')]
    public function partner(PartnerRepository $repoPartner): Response
    {
        $partner = $repoPartner->findAll();


        return $this->render('view/partner.html.twig', [
            'controller_name' => 'ViewController',
            'partners' => $partner
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/partenaire/{id}', name: 'app_view_partner')]
    public function viewPartner($id, PartnerRepository $repoPartner, StructureRepository $repoStructure): Response
    {
        $partner = $repoPartner->find($id);
        $structures = $repoStructure->findBy(['partner' => $id]);
            if (!$partner) {
            throw $this->createNotFoundException('Cette page n\'existe pas');
        } 

        return $this->render('view/view_partner.html.twig', [
            'controller_name' => 'ViewController',
            'partner' => $partner,
            'structures' => $structures

        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/structure/{id}', name: 'app_view_structure')]
    public function viewStructure($id, StructureRepository $repoStructure): Response
    {
        $structure = $repoStructure->find($id);
        if (!$structure) {
            throw $this->createNotFoundException('Cette page n\'existe pas');
        }


        return $this->render('view/view_structure.html.twig', [
            'controller_name' => 'ViewController',
            'structure' => $structure

        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/recherche', name: 'app_search')]
    public function search(StructureRepository $repoStructure, PartnerRepository $repoPartner): Response
    {
        $structures = $repoStructure->findAll();
        $partners = $repoPartner->findAll();


        return $this->render('view/search.html.twig', [
            'controller_name' => 'ViewController',
            'structures' => $structures,
            'partners' => $partners,

        ]);
    }

    
}

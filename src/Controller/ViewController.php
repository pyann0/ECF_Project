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
    #[IsGranted('ROLE_USER')]
    #[Route('/', name: 'app_home')]
    public function home(PartnerRepository $repoPartner, StructureRepository $repoStructure): Response
    {
        $partners = $repoPartner->getThreePartner();
        $structures = $repoStructure->getThreeStructure();

        
        return $this->render('view/home.html.twig', [
            'controller_name' => 'ViewController',
            'partners' => $partners,
            'structures' => $structures
        ]);
    }
    

    #[IsGranted('ROLE_USER')]
    #[Route('/partenaires', name: 'app_partners')]
    public function partner(PartnerRepository $repoPartner): Response
    {
        $partner = $repoPartner->findAll();


        return $this->render('view/partner.html.twig', [
            'controller_name' => 'ViewController',
            'partners' => $partner
        ]);
    }
    
    #[IsGranted('ROLE_USER')]
    #[Route('/structures', name: 'app_structures')]
    public function structures(StructureRepository $repoStructure): Response
    {
        $structures = $repoStructure->findAll();


        return $this->render('view/structures.html.twig', [
            'controller_name' => 'ViewController',
            'structures' => $structures
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

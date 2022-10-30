<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\Structure;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/structure/{id}/delete', name: 'app_delete_structure')]
    public function deleteStructure($id, Structure $structure = null, EntityManagerInterface $manager, PartnerRepository $repoPartner,): Response
    {

        $manager->remove($structure);
        $manager->flush();


        return $this->redirectToRoute('app_structures');
    }




    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire/{id}/delete', name: 'app_delete_partner')]
    public function deletePartner($id, Partner $partner = null, EntityManagerInterface $manager, PartnerRepository $repoPartner,): Response
    {

        $manager->remove($partner);
        $manager->flush();


        return $this->redirectToRoute('app_partners');
    }
}

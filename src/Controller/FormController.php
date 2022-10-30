<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Entity\Structure;
use App\Form\PartnerEditType;
use App\Form\PartnerType;
use App\Form\StructureEditType;
use App\Form\StructureType;
use App\Repository\PartnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire/{id}/modifier', name: 'app_edit_partner')]
    #[Route('/partenaire/creer', name: 'app_create_partner')]
    public function partner(Partner $partner = null, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        if (!$partner) {
            $partner = new Partner();
            $formPartner = $this->createForm(PartnerType::class, $partner);
            $needPassword = true;
        } else {
            $formPartner = $this->createForm(PartnerEditType::class, $partner);
            $needPassword = false;
        }


        $formPartner->handleRequest($request);
        if ($formPartner->isSubmitted() && $formPartner->isValid()) {
            if ($needPassword) {
                $user = $partner->getUsername();
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $formPartner->get('username')->get('plainPassword')->getData()
                    )
                );
                $user->setRoles(["ROLE_USER"]);
            }




            $manager->persist($partner);
            $manager->flush();
            return $this->redirectToRoute('app_partners');
        }

        return $this->render('form/partner.html.twig', [
            'controller_name' => 'FormController',
            'formPartner' => $formPartner->createView(),
            'editMode' => $partner->getId() !== null
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/partenaire-structure/{id}/creer', name: 'app_create_structure')]
    public function createStructure($id, Structure $structure = null, Request $request, EntityManagerInterface $manager, PartnerRepository $repoPartner, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $partner = $repoPartner->find($id);


        $structure = new Structure();
        $structure->setPartner($partner);


        $formStructure = $this->createForm(StructureType::class, $structure);
        $formStructure->handleRequest($request);
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {

            $user = $structure->getUsername();
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formStructure->get('username')->get('plainPassword')->getData()
                )
            );
            $user->setRoles(["ROLE_USER"]);


            $manager->persist($structure);
            $manager->flush();
            return $this->redirectToRoute('app_structures');
        }

        return $this->render('form/create_structure.html.twig', [
            'controller_name' => 'FormController',
            'formStructure' => $formStructure->createView(),
            'partner' => $partner
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/structure/{id}/modifer', name: 'app_edit_structure')]
    public function editStructure($id, Structure $structure = null, Request $request, EntityManagerInterface $manager, PartnerRepository $repoPartner,): Response
    {

        $formStructure = $this->createForm(StructureEditType::class, $structure);
        $formStructure->handleRequest($request);
        if ($formStructure->isSubmitted() && $formStructure->isValid()) {



            $manager->persist($structure);
            $manager->flush();
            return $this->redirectToRoute('app_structures');
        }

        return $this->render('form/edit_structure.html.twig', [
            'controller_name' => 'FormController',
            'formStructure' => $formStructure->createView(),
        ]);
    }
}

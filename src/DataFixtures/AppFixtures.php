<?php

namespace App\DataFixtures;

use App\Entity\Features;
use App\Entity\Partner;
use App\Entity\Structure;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();
        $passwordAdmin = $this->hasher->hashPassword($userAdmin, 'motdepasseadmin'); 
        $userAdmin->setEmail('admin@admin.com')
                ->setDescription('Loren ipsun dolor sit anet, consectetur adipisci elit, sed eiusnod tenpor incidunt ut labore et dolore nagna aliqua. Ut enin ad ninin venian, quis nostrun exercitationen ullan corporis suscipit laboriosan, nisi ut aliquid ex ea connodi consequatur.')
                ->setPhone('0611121314')
                ->setPassword($passwordAdmin)
                ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($userAdmin);

        for($i =1; $i <= 6; $i++){
            $user = new User();
            $passwordPartner = $this->hasher->hashPassword($user, 'motdepassepartenaire'); 
            $user->setEmail("partenaire$i@partenaire.com")            
                ->setPassword($passwordPartner)
                ->setPhone('0612131415')
                ->setDescription('Loren ipsun dolor sit anet, consectetur adipisci elit, sed eiusnod tenpor incidunt ut labore et dolore nagna aliqua. Ut enin ad ninin venian, quis nostrun exercitationen ullan corporis suscipit laboriosan, nisi ut aliquid ex ea connodi consequatur.')
                ->setRoles(["ROLE_USER"]);
            $manager->persist($user);

            $features = new Features();
            $features->setEnvoyerNewsletter(rand(0,1))
                     ->setVendreBoisson(rand(0,1))
                     ->setGererPlanning(rand(0,1));
            $manager->persist($features);

            $partner = new Partner();
            $partner->setUsername($user)
                    ->setName("Partenaire n°$i")
                    ->setActive(1)
                    ->setFeatures($features);
            $manager->persist($partner);

            for($j = 1; $j <= 6; $j++ ){                
                $userStructure = new User();
                $passwordStructure = $this->hasher->hashPassword($userStructure, 'motdepassestructure');
                $userStructure->setEmail("structure$j@partenaire$i.com")
                            ->setPassword($passwordStructure)
                            ->setPhone('0612131415')
                            ->setDescription('Loren ipsun dolor sit anet, consectetur adipisci elit, sed eiusnod tenpor incidunt ut labore et dolore nagna aliqua. Ut enin ad ninin venian, quis nostrun exercitationen ullan corporis suscipit laboriosan, nisi ut aliquid ex ea connodi consequatur.')
                            ->setRoles(["ROLE_USER"]);
                $manager->persist($userStructure);

            $featuresStructure = new Features();
            $featuresStructure->setEnvoyerNewsletter(rand(0,1))
                     ->setVendreBoisson(rand(0,1))
                     ->setGererPlanning(rand(0,1));
            $manager->persist($featuresStructure);

            $structure = new Structure();
            $structure->setUsername($userStructure)
                    ->setAdress("$j Rue du partenaire $i")
                    ->setActive(rand(0,1))
                    ->setFeatures($featuresStructure)
                    ->setPartner($partner);

            $manager->persist($structure);
            }
            

        }

        $manager->flush();
    }
}

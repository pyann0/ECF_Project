<?php

namespace App\Entity;

use App\Repository\FeaturesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeaturesRepository::class)]
class Features
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $vendre_boisson = null;

    #[ORM\Column]
    private ?bool $gerer_planning = null;

    #[ORM\Column]
    private ?bool $envoyer_newsletter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendreBoisson(): ?bool
    {
        return $this->vendre_boisson;
    }

    public function setVendreBoisson(bool $vendre_boisson): self
    {
        $this->vendre_boisson = $vendre_boisson;

        return $this;
    }

    public function getGererPlanning(): ?bool
    {
        return $this->gerer_planning;
    }

    public function setGererPlanning(bool $gerer_planning): self
    {
        $this->gerer_planning = $gerer_planning;

        return $this;
    }

    public function getEnvoyerNewsletter(): ?bool
    {
        return $this->envoyer_newsletter;
    }

    public function setEnvoyerNewsletter(bool $envoyer_newsletter): self
    {
        $this->envoyer_newsletter = $envoyer_newsletter;

        return $this;
    }
}

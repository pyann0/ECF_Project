<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 2,
        max: 254,
        maxMessage: 'Entrez une adresse e-mail de moins de 254 caractères.',
    )]
    #[Assert\Email(
        message: 'Veuillez entrer une adresse email correct !',
    )]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[Assert\Length(
        min: 8,
        max: 180,
        minMessage: 'Votre mot de passe est trop court',
        maxMessage: 'Créez un mot de passe plus long',
    )]
    #[ORM\Column]
    private ?string $password = null;

    #[Assert\Length(
        min: 4,
        max: 60,
        maxMessage: 'Votre numéro de téléphone est incorrect',
    )]
    #[Assert\Regex(
        pattern: '/^((\+)33|0|0033)[1-9](\d{2}){4}$/ ',
        message: 'Votre numéro est incorrect',
    )]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[Assert\Length(
        min: 0,
        max: 255,
        maxMessage: 'Votre description a dépassé la limite de caractère atteignable',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'username', cascade: ['persist', 'remove'])]
    private ?Partner $partner = null;

    #[ORM\OneToOne(mappedBy: 'username', cascade: ['persist', 'remove'])]
    private ?Structure $structure = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPartner(): ?Partner
    {
        return $this->partner;
    }

    public function setPartner(Partner $partner): self
    {
        // set the owning side of the relation if necessary
        if ($partner->getUsername() !== $this) {
            $partner->setUsername($this);
        }

        $this->partner = $partner;

        return $this;
    }

    public function getStructure(): ?Structure
    {
        return $this->structure;
    }

    public function setStructure(Structure $structure): self
    {
        // set the owning side of the relation if necessary
        if ($structure->getUsername() !== $this) {
            $structure->setUsername($this);
        }

        $this->structure = $structure;

        return $this;
    }
}

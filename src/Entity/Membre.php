<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

use function Symfony\Component\String\u;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['login'], message: 'Ce login est déjà utilisé.')]
class Membre implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: 'Le nom complet est obligatoire.')]
    #[Assert\Length(min: 2, max: 150, minMessage: 'Le nom complet doit contenir au moins {{ limit }} caractères.', maxMessage: 'Le nom complet ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $nomComplet = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le téléphone est obligatoire.')]
    #[Assert\Regex(pattern: '/^(\+221)?7[05678]\d{7}$/', message: 'Le numéro de téléphone n\'est pas un numéro sénégalais valide.')]
    private ?string $telephone = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255, maxMessage: 'L\'adresse ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $adresse = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le login est obligatoire.')]
    #[Assert\Length(min: 3, max: 50, minMessage: 'Le login doit contenir au moins {{ limit }} caractères.', maxMessage: 'Le login ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $login = null;

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le rôle est obligatoire.')]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le groupement est obligatoire.')]
    private ?Groupement $groupement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): static
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    public function getRoles(): array
    {
        $roles = ['ROLE_USER'];

        if (null !== $this->role?->getNom()) {
            $roles[] = 'ROLE_'.u($this->role->getNom())->ascii()->snake()->upper();
        }

        return array_unique($roles);
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }
}

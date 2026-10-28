<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['nom'], message: 'Ce rôle existe déjà.')]
class Role
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'Le nom du rôle est obligatoire.')]
    #[Assert\Length(max: 50, maxMessage: 'Le nom du rôle ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Membre::class, mappedBy: 'role')]
    private Collection $membres;

    public function __construct()
    {
        $this->membres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setRole($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            if ($membre->getRole() === $this) {
                $membre->setRole(null);
            }
        }

        return $this;
    }
}

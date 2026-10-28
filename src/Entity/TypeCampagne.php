<?php

namespace App\Entity;

use App\Repository\TypeCampagneRepository;
use App\Trait\DateTimeTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeCampagneRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['nom'], message: 'Ce type de campagne existe déjà.')]
class TypeCampagne
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank(message: 'Le nom du type de campagne est obligatoire.')]
    #[Assert\Length(max: 100, maxMessage: 'Le nom du type de campagne ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Campagne::class, mappedBy: 'typeCampagne')]
    private Collection $campagnes;

    public function __construct()
    {
        $this->campagnes = new ArrayCollection();
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

    public function getCampagnes(): Collection
    {
        return $this->campagnes;
    }

    public function addCampagne(Campagne $campagne): static
    {
        if (!$this->campagnes->contains($campagne)) {
            $this->campagnes->add($campagne);
            $campagne->setTypeCampagne($this);
        }

        return $this;
    }

    public function removeCampagne(Campagne $campagne): static
    {
        if ($this->campagnes->removeElement($campagne)) {
            if ($campagne->getTypeCampagne() === $this) {
                $campagne->setTypeCampagne(null);
            }
        }

        return $this;
    }
}

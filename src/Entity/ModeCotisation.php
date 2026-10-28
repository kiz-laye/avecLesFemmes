<?php

namespace App\Entity;

use App\Repository\ModeCotisationRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ModeCotisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'uniq_membre_campagne', columns: ['membre_id', 'campagne_id'])]
#[UniqueEntity(fields: ['membre', 'campagne'], message: 'Ce membre est déjà affecté à cette campagne.')]
class ModeCotisation
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private bool $isLibre = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La campagne est obligatoire.')]
    private ?Campagne $campagne = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le membre est obligatoire.')]
    private ?Membre $membre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isLibre(): bool
    {
        return $this->isLibre;
    }

    public function setIsLibre(bool $isLibre): static
    {
        $this->isLibre = $isLibre;

        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): static
    {
        $this->campagne = $campagne;

        return $this;
    }

    public function getMembre(): ?Membre
    {
        return $this->membre;
    }

    public function setMembre(?Membre $membre): static
    {
        $this->membre = $membre;

        return $this;
    }
}

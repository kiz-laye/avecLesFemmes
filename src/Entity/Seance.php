<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'uniq_campagne_numero', columns: ['campagne_id', 'numero'])]
#[UniqueEntity(fields: ['campagne', 'numero'], message: 'Ce numéro de séance existe déjà pour cette campagne.')]
class Seance
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le numéro de la séance est obligatoire.')]
    #[Assert\Positive(message: 'Le numéro de la séance doit être supérieur à 0.')]
    private ?int $numero = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de la séance est obligatoire.')]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private bool $isTenue = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La campagne est obligatoire.')]
    private ?Campagne $campagne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function isTenue(): bool
    {
        return $this->isTenue;
    }

    public function setIsTenue(bool $isTenue): static
    {
        $this->isTenue = $isTenue;

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
}

<?php

namespace App\Entity;

use App\Repository\AmendeRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AmendeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Amende
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive(message: 'Le nombre de jours doit être supérieur à 0.')]
    private int $nbJours = 1;

    #[ORM\Column]
    #[Assert\Positive(message: 'Le montant par jour doit être supérieur à 0.')]
    private int $montantJour = 0;

    #[ORM\Column]
    private int $montantTotal = 0;

    #[ORM\Column]
    private bool $isPayee = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le mode de cotisation est obligatoire.')]
    private ?ModeCotisation $mode = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La séance est obligatoire.')]
    private ?Seance $seance = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbJours(): int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): static
    {
        $this->nbJours = $nbJours;
        $this->calculerMontantTotal();

        return $this;
    }

    public function getMontantJour(): int
    {
        return $this->montantJour;
    }

    public function setMontantJour(int $montantJour): static
    {
        $this->montantJour = $montantJour;
        $this->calculerMontantTotal();

        return $this;
    }

    public function getMontantTotal(): int
    {
        return $this->montantTotal;
    }

    public function isPayee(): bool
    {
        return $this->isPayee;
    }

    public function setIsPayee(bool $isPayee): static
    {
        $this->isPayee = $isPayee;

        return $this;
    }

    public function getMode(): ?ModeCotisation
    {
        return $this->mode;
    }

    public function setMode(?ModeCotisation $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;

        return $this;
    }

    private function calculerMontantTotal(): void
    {
        $this->montantTotal = $this->nbJours * $this->montantJour;
    }
}

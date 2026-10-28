<?php

namespace App\Entity;

use App\Enum\StatutExercice;
use App\Repository\ExerciceRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Exercice
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de début est obligatoire.')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de fin est obligatoire.')]
    #[Assert\GreaterThan(propertyPath: 'dateDebut', message: 'La date de fin doit être après la date de début.')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date limite des prêts est obligatoire.')]
    #[Assert\GreaterThanOrEqual(propertyPath: 'dateDebut', message: 'La date limite des prêts doit être après la date de début.')]
    #[Assert\LessThanOrEqual(propertyPath: 'dateFin', message: 'La date limite des prêts doit être avant la date de fin.')]
    private ?\DateTimeInterface $dateLimitePret = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de rétribution est obligatoire.')]
    #[Assert\GreaterThanOrEqual(propertyPath: 'dateDebut', message: 'La date de rétribution doit être après la date de début.')]
    private ?\DateTimeInterface $dateRetribution = null;

    #[ORM\Column(enumType: StatutExercice::class)]
    #[Assert\NotNull(message: 'Le statut est obligatoire.')]
    private ?StatutExercice $statut = StatutExercice::EN_COURS;

    #[ORM\ManyToOne(inversedBy: 'exercices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le groupement est obligatoire.')]
    private ?Groupement $groupement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getDateLimitePret(): ?\DateTimeInterface
    {
        return $this->dateLimitePret;
    }

    public function setDateLimitePret(\DateTimeInterface $dateLimitePret): static
    {
        $this->dateLimitePret = $dateLimitePret;

        return $this;
    }

    public function getDateRetribution(): ?\DateTimeInterface
    {
        return $this->dateRetribution;
    }

    public function setDateRetribution(\DateTimeInterface $dateRetribution): static
    {
        $this->dateRetribution = $dateRetribution;

        return $this;
    }

    public function getStatut(): ?StatutExercice
    {
        return $this->statut;
    }

    public function setStatut(StatutExercice $statut): static
    {
        $this->statut = $statut;

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

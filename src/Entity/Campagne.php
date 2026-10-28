<?php

namespace App\Entity;

use App\Enum\Periodicite;
use App\Repository\CampagneRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CampagneRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Campagne
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom de la campagne est obligatoire.')]
    #[Assert\Length(max: 100, maxMessage: 'Le nom ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de début est obligatoire.')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date de fin est obligatoire.')]
    #[Assert\GreaterThanOrEqual(propertyPath: 'dateDebut', message: 'La date de fin doit être après la date de début.')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(enumType: Periodicite::class)]
    #[Assert\NotNull(message: 'La périodicité est obligatoire.')]
    private ?Periodicite $periodicite = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Le jour de rencontre est obligatoire.')]
    private ?string $jourRencontre = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant fixe est obligatoire.')]
    #[Assert\Positive(message: 'Le montant fixe doit être supérieur à 0.')]
    private ?int $montantFixe = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant de caisse (présent) est obligatoire.')]
    #[Assert\PositiveOrZero(message: 'Le montant de caisse (présent) ne peut pas être négatif.')]
    private ?int $caissePresent = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant de caisse (absent) est obligatoire.')]
    #[Assert\PositiveOrZero(message: 'Le montant de caisse (absent) ne peut pas être négatif.')]
    private ?int $caisseAbsent = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant de l\'amende journalière est obligatoire.')]
    #[Assert\PositiveOrZero(message: 'L\'amende journalière ne peut pas être négative.')]
    private ?int $amendeJour = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'L\'exercice est obligatoire.')]
    private ?Exercice $exercice = null;

    #[ORM\ManyToOne(inversedBy: 'campagnes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le type de campagne est obligatoire.')]
    private ?TypeCampagne $typeCampagne = null;

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

    public function getPeriodicite(): ?Periodicite
    {
        return $this->periodicite;
    }

    public function setPeriodicite(Periodicite $periodicite): static
    {
        $this->periodicite = $periodicite;

        return $this;
    }

    public function getJourRencontre(): ?string
    {
        return $this->jourRencontre;
    }

    public function setJourRencontre(string $jourRencontre): static
    {
        $this->jourRencontre = $jourRencontre;

        return $this;
    }

    public function getMontantFixe(): ?int
    {
        return $this->montantFixe;
    }

    public function setMontantFixe(int $montantFixe): static
    {
        $this->montantFixe = $montantFixe;

        return $this;
    }

    public function getCaissePresent(): ?int
    {
        return $this->caissePresent;
    }

    public function setCaissePresent(int $caissePresent): static
    {
        $this->caissePresent = $caissePresent;

        return $this;
    }

    public function getCaisseAbsent(): ?int
    {
        return $this->caisseAbsent;
    }

    public function setCaisseAbsent(int $caisseAbsent): static
    {
        $this->caisseAbsent = $caisseAbsent;

        return $this;
    }

    public function getAmendeJour(): ?int
    {
        return $this->amendeJour;
    }

    public function setAmendeJour(int $amendeJour): static
    {
        $this->amendeJour = $amendeJour;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): static
    {
        $this->exercice = $exercice;

        return $this;
    }

    public function getTypeCampagne(): ?TypeCampagne
    {
        return $this->typeCampagne;
    }

    public function setTypeCampagne(?TypeCampagne $typeCampagne): static
    {
        $this->typeCampagne = $typeCampagne;

        return $this;
    }
}

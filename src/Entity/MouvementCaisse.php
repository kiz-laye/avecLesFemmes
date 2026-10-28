<?php

namespace App\Entity;

use App\Enum\TypeMouvement;
use App\Repository\MouvementCaisseRepository;
use App\Trait\DateTimeTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MouvementCaisseRepository::class)]
#[ORM\HasLifecycleCallbacks]
class MouvementCaisse
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant est obligatoire.')]
    #[Assert\Positive(message: 'Le montant doit être supérieur à 0.')]
    private ?int $montant = null;

    #[ORM\Column(enumType: TypeMouvement::class)]
    #[Assert\NotNull(message: 'Le type de mouvement est obligatoire.')]
    private ?TypeMouvement $type = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotNull(message: 'La date est obligatoire.')]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La caisse est obligatoire.')]
    private ?CaisseSociale $caisse = null;

    #[ORM\ManyToOne]
    private ?Cotisation $cotisation = null;

    #[ORM\ManyToOne]
    private ?Amende $amende = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getType(): ?TypeMouvement
    {
        return $this->type;
    }

    public function setType(TypeMouvement $type): static
    {
        $this->type = $type;

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

    public function getCaisse(): ?CaisseSociale
    {
        return $this->caisse;
    }

    public function setCaisse(?CaisseSociale $caisse): static
    {
        $this->caisse = $caisse;

        return $this;
    }

    public function getCotisation(): ?Cotisation
    {
        return $this->cotisation;
    }

    public function setCotisation(?Cotisation $cotisation): static
    {
        $this->cotisation = $cotisation;

        return $this;
    }

    public function getAmende(): ?Amende
    {
        return $this->amende;
    }

    public function setAmende(?Amende $amende): static
    {
        $this->amende = $amende;

        return $this;
    }
}

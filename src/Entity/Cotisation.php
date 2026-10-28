<?php

namespace App\Entity;

use App\Enum\TypePresence;
use App\Repository\CotisationRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CotisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'uniq_seance_mode', columns: ['seance_id', 'mode_id'])]
#[UniqueEntity(fields: ['seance', 'mode'], message: 'Ce membre a déjà une cotisation pour cette séance.')]
class Cotisation
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant de l\'épargne est obligatoire.')]
    #[Assert\PositiveOrZero(message: 'Le montant de l\'épargne ne peut pas être négatif.')]
    private ?int $montantEpargne = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le montant de la caisse est obligatoire.')]
    #[Assert\PositiveOrZero(message: 'Le montant de la caisse ne peut pas être négatif.')]
    private ?int $montantCaisse = null;

    #[ORM\Column(enumType: TypePresence::class)]
    #[Assert\NotNull(message: 'La présence est obligatoire.')]
    private ?TypePresence $presence = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'La séance est obligatoire.')]
    private ?Seance $seance = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: 'Le mode de cotisation est obligatoire.')]
    private ?ModeCotisation $mode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantEpargne(): ?int
    {
        return $this->montantEpargne;
    }

    public function setMontantEpargne(int $montantEpargne): static
    {
        $this->montantEpargne = $montantEpargne;

        return $this;
    }

    public function getMontantCaisse(): ?int
    {
        return $this->montantCaisse;
    }

    public function setMontantCaisse(int $montantCaisse): static
    {
        $this->montantCaisse = $montantCaisse;

        return $this;
    }

    public function getPresence(): ?TypePresence
    {
        return $this->presence;
    }

    public function setPresence(TypePresence $presence): static
    {
        $this->presence = $presence;

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

    public function getMode(): ?ModeCotisation
    {
        return $this->mode;
    }

    public function setMode(?ModeCotisation $mode): static
    {
        $this->mode = $mode;

        return $this;
    }
}

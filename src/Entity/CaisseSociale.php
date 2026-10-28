<?php

namespace App\Entity;

use App\Repository\CaisseSocialeRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CaisseSocialeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CaisseSociale
{
    use DateTimeTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero(message: 'Le solde ne peut pas être négatif.')]
    private int $solde = 0;

    #[ORM\OneToOne]
    #[ORM\JoinColumn(nullable: false, unique: true)]
    #[Assert\NotNull(message: 'L\'exercice est obligatoire.')]
    private ?Exercice $exercice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSolde(): int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(Exercice $exercice): static
    {
        $this->exercice = $exercice;

        return $this;
    }
}

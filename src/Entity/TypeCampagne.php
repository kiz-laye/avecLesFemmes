<?php

namespace App\Entity;

use App\Repository\TypeCampagneRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeCampagneRepository::class)]
#[UniqueEntity(fields: ['nom'], message: 'Ce type de campagne existe déjà.')]
class TypeCampagne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank(message: 'Le nom du type de campagne est obligatoire.')]
    #[Assert\Length(max: 100, maxMessage: 'Le nom du type de campagne ne doit pas dépasser {{ limit }} caractères.')]
    private ?string $nom = null;

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
}

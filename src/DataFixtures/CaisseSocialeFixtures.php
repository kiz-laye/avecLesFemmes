<?php

namespace App\DataFixtures;

use App\Entity\CaisseSociale;
use App\Repository\ExerciceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CaisseSocialeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly ExerciceRepository $exerciceRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->exerciceRepository->findAll() as $exercice) {
            $manager->persist((new CaisseSociale())->setExercice($exercice));
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ExerciceFixtures::class];
    }
}

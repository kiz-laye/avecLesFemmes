<?php

namespace App\DataFixtures;

use App\Entity\ModeCotisation;
use App\Repository\CampagneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModeCotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly CampagneRepository $campagneRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->campagneRepository->findAll() as $campagne) {
            foreach ($campagne->getExercice()->getGroupement()->getMembres() as $m => $membre) {
                $mode = (new ModeCotisation())
                    ->setCampagne($campagne)
                    ->setMembre($membre)
                    ->setIsLibre(3 === $m % 4);

                $manager->persist($mode);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class, MembreFixtures::class];
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Enum\StatutExercice;
use App\Repository\GroupementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciceFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly GroupementRepository $groupementRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->groupementRepository->findAll() as $groupement) {
            $ancien = (new Exercice())
                ->setDateDebut(new \DateTime('2025-01-05'))
                ->setDateFin(new \DateTime('2025-12-28'))
                ->setDateLimitePret(new \DateTime('2025-10-12'))
                ->setDateRetribution(new \DateTime('2025-11-02'))
                ->setStatut(StatutExercice::CLOTURE);

            $enCours = (new Exercice())
                ->setDateDebut(new \DateTime('2026-01-04'))
                ->setDateFin(new \DateTime('2026-12-27'))
                ->setDateLimitePret(new \DateTime('2026-10-11'))
                ->setDateRetribution(new \DateTime('2026-11-01'))
                ->setStatut(StatutExercice::EN_COURS);

            $groupement->addExercice($ancien)->addExercice($enCours);

            $manager->persist($ancien);
            $manager->persist($enCours);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }
}

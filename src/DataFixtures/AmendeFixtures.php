<?php

namespace App\DataFixtures;

use App\Entity\Amende;
use App\Enum\TypePresence;
use App\Repository\CotisationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AmendeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly CotisationRepository $cotisationRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $absences = $this->cotisationRepository->findBy(['presence' => TypePresence::ABSENT_NON_PAYE]);

        foreach ($absences as $a => $cotisation) {
            $amendeJour = $cotisation->getSeance()->getCampagne()->getAmendeJour();

            if ($amendeJour <= 0) {
                continue;
            }

            $amende = (new Amende())
                ->setMode($cotisation->getMode())
                ->setSeance($cotisation->getSeance())
                ->setMontantJour($amendeJour)
                ->setNbJours(3)
                ->setIsPayee(0 === $a % 2);

            $manager->persist($amende);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CotisationFixtures::class];
    }
}

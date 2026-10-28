<?php

namespace App\DataFixtures;

use App\Entity\Seance;
use App\Enum\Periodicite;
use App\Repository\CampagneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    public const NOMBRE_SEANCES = 4;

    public function __construct(private readonly CampagneRepository $campagneRepository)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $intervalles = [
            Periodicite::HEBDOMADAIRE->value => '+1 week',
            Periodicite::BIMENSUEL->value => '+2 weeks',
            Periodicite::QUINZAINE->value => '+15 days',
            Periodicite::MENSUEL->value => '+1 month',
        ];

        foreach ($this->campagneRepository->findAll() as $campagne) {
            $date = \DateTime::createFromInterface($campagne->getDateDebut());

            for ($numero = 1; $numero <= self::NOMBRE_SEANCES; ++$numero) {
                $seance = (new Seance())
                    ->setNumero($numero)
                    ->setDate(clone $date)
                    ->setIsTenue($numero < self::NOMBRE_SEANCES)
                    ->setCampagne($campagne);

                $manager->persist($seance);
                $date->modify($intervalles[$campagne->getPeriodicite()->value]);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CampagneFixtures::class];
    }
}

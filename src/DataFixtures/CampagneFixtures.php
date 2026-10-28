<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Enum\Periodicite;
use App\Repository\ExerciceRepository;
use App\Repository\TypeCampagneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampagneFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly ExerciceRepository $exerciceRepository,
        private readonly TypeCampagneRepository $typeCampagneRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $campagnes = [
            ['Épargne calebasse', 'épargne calebasse', Periodicite::HEBDOMADAIRE, 'dimanche', 1000, 100, 300, 350],
            ['Tontine mensuelle', 'tontine', Periodicite::MENSUEL, 'premier dimanche', 5000, 0, 0, 500],
        ];

        foreach ($this->exerciceRepository->findAll() as $exercice) {
            foreach ($campagnes as [$nom, $type, $periodicite, $jour, $montant, $caissePresent, $caisseAbsent, $amendeJour]) {
                $campagne = (new Campagne())
                    ->setNom($nom)
                    ->setDateDebut($exercice->getDateDebut())
                    ->setDateFin($exercice->getDateFin())
                    ->setPeriodicite($periodicite)
                    ->setJourRencontre($jour)
                    ->setMontantFixe($montant)
                    ->setCaissePresent($caissePresent)
                    ->setCaisseAbsent($caisseAbsent)
                    ->setAmendeJour($amendeJour)
                    ->setExercice($exercice)
                    ->setTypeCampagne($this->typeCampagneRepository->findOneBy(['nom' => $type]));

                $manager->persist($campagne);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ExerciceFixtures::class, TypeCampagneFixtures::class];
    }
}

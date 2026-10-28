<?php

namespace App\DataFixtures;

use App\Entity\Cotisation;
use App\Enum\TypePresence;
use App\Repository\ModeCotisationRepository;
use App\Repository\SeanceRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly SeanceRepository $seanceRepository,
        private readonly ModeCotisationRepository $modeCotisationRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $presences = [
            TypePresence::PRESENT,
            TypePresence::PRESENT,
            TypePresence::ABSENT_PAYE,
            TypePresence::PRESENT,
            TypePresence::ABSENT_NON_PAYE,
        ];

        foreach ($this->seanceRepository->findBy(['isTenue' => true]) as $s => $seance) {
            $campagne = $seance->getCampagne();
            $modes = $this->modeCotisationRepository->findBy(['campagne' => $campagne]);

            foreach ($modes as $m => $mode) {
                $presence = $presences[($s + $m) % count($presences)];

                [$epargne, $caisse] = match ($presence) {
                    TypePresence::PRESENT => [$this->montantEpargne($mode->isLibre(), $campagne->getMontantFixe(), $m), $campagne->getCaissePresent()],
                    TypePresence::ABSENT_PAYE => [$this->montantEpargne($mode->isLibre(), $campagne->getMontantFixe(), $m), $campagne->getCaisseAbsent()],
                    TypePresence::ABSENT_NON_PAYE => [0, 0],
                };

                $cotisation = (new Cotisation())
                    ->setSeance($seance)
                    ->setMode($mode)
                    ->setPresence($presence)
                    ->setMontantEpargne($epargne)
                    ->setMontantCaisse($caisse);

                $manager->persist($cotisation);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeanceFixtures::class, ModeCotisationFixtures::class];
    }

    private function montantEpargne(bool $isLibre, int $montantFixe, int $rang): int
    {
        return $isLibre ? $montantFixe + 500 * ($rang % 3 + 1) : $montantFixe;
    }
}

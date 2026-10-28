<?php

namespace App\DataFixtures;

use App\Entity\MouvementCaisse;
use App\Enum\TypeMouvement;
use App\Enum\TypePresence;
use App\Repository\AmendeRepository;
use App\Repository\CaisseSocialeRepository;
use App\Repository\CotisationRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MouvementCaisseFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private readonly CotisationRepository $cotisationRepository,
        private readonly AmendeRepository $amendeRepository,
        private readonly CaisseSocialeRepository $caisseSocialeRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $caisses = [];
        foreach ($this->caisseSocialeRepository->findAll() as $caisse) {
            $caisses[$caisse->getExercice()->getId()] = $caisse;
        }

        foreach ($this->cotisationRepository->findAll() as $cotisation) {
            if ($cotisation->getMontantCaisse() <= 0) {
                continue;
            }

            $seance = $cotisation->getSeance();
            $caisse = $caisses[$seance->getCampagne()->getExercice()->getId()];

            $mouvement = (new MouvementCaisse())
                ->setMontant($cotisation->getMontantCaisse())
                ->setType(TypePresence::PRESENT === $cotisation->getPresence() ? TypeMouvement::CAISSE_PRESENT : TypeMouvement::CAISSE_ABSENT)
                ->setDate($seance->getDate())
                ->setCaisse($caisse)
                ->setCotisation($cotisation);

            $caisse->setSolde($caisse->getSolde() + $mouvement->getMontant());
            $manager->persist($mouvement);
        }

        foreach ($this->amendeRepository->findBy(['isPayee' => true]) as $amende) {
            $seance = $amende->getSeance();
            $caisse = $caisses[$seance->getCampagne()->getExercice()->getId()];

            $mouvement = (new MouvementCaisse())
                ->setMontant($amende->getMontantTotal())
                ->setType(TypeMouvement::AMENDE)
                ->setDate($seance->getDate())
                ->setCaisse($caisse)
                ->setAmende($amende);

            $caisse->setSolde($caisse->getSolde() + $mouvement->getMontant());
            $manager->persist($mouvement);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [CotisationFixtures::class, AmendeFixtures::class, CaisseSocialeFixtures::class];
    }
}

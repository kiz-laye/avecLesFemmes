<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $groupements = [
            ['Jappo Jigeen', '771234567', 'Pikine, Dakar'],
            ['Bokk Jom', '781234567', 'Rufisque'],
            ['And Liggey', '761234567', null],
        ];

        foreach ($groupements as [$nom, $telephone, $adresse]) {
            $groupement = (new Groupement())
                ->setNom($nom)
                ->setTelephone($telephone)
                ->setAdresse($adresse);

            $manager->persist($groupement);
        }

        $manager->flush();
    }
}

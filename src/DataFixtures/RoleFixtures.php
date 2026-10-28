<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $roles = ['membre simple', 'trésorière', 'secrétaire', 'admin'];

        foreach ($roles as $nom) {
            $manager->persist((new Role())->setNom($nom));
        }

        $manager->flush();
    }
}

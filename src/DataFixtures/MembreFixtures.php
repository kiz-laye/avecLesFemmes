<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use App\Repository\GroupementRepository;
use App\Repository\RoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MembreFixtures extends Fixture implements DependentFixtureInterface
{
    public const MOT_DE_PASSE = 'passer123';

    public function __construct(
        private readonly GroupementRepository $groupementRepository,
        private readonly RoleRepository $roleRepository,
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $membres = [
            ['Awa Diop', 'admin'],
            ['Fatou Ndiaye', 'trésorière'],
            ['Mariama Ba', 'secrétaire'],
            ['Aminata Sow', 'membre simple'],
            ['Khady Fall', 'membre simple'],
            ['Ndeye Sarr', 'membre simple'],
        ];

        $roles = [];
        foreach ($this->roleRepository->findAll() as $role) {
            $roles[$role->getNom()] = $role;
        }

        foreach ($this->groupementRepository->findAll() as $g => $groupement) {
            foreach ($membres as $m => [$nomComplet, $nomRole]) {
                $membre = (new Membre())
                    ->setNomComplet($nomComplet)
                    ->setTelephone(sprintf('77%d%06d', $g + 1, $m + 1))
                    ->setAdresse($groupement->getAdresse())
                    ->setLogin(sprintf('%s%d', strtolower(explode(' ', $nomComplet)[0]), $g + 1))
                    ->setRole($roles[$nomRole]);

                $membre->setPassword($this->hasher->hashPassword($membre, self::MOT_DE_PASSE));
                $groupement->addMembre($membre);

                $manager->persist($membre);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [RoleFixtures::class, GroupementFixtures::class];
    }
}

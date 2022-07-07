<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{   

    public function __construct( UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail("gabbo@porcoddio.it");
        $user->addRole('ROLE_ADMIN');
        $user->setPassword($this->userPasswordHasher->hashPassword(
            $user,
            "tuamadre"
            )
        );
        $manager->persist($user);

        $user = new User();
        $user->setEmail("gabbo@porcamadonna.it");
        $user->setPassword($this->userPasswordHasher->hashPassword(
            $user,
            "tuamadre"
            )
        );
        $manager->persist($user);

        $manager->flush();
    }
}

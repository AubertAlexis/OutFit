<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHaser;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHaser = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $administrator = new Administrator();

            $administrator->setUser($user);

            $user->setEmail("admin+$i@gmail.com")
                ->setPassword("password")
                ->setRoles([User::ROLE_ADMINISTRATOR]);

            $manager->persist($administrator);
        }

        $manager->flush();
    }
}
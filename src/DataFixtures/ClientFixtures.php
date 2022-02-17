<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Customer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $customer = new Customer();

            $customer->setUser($user)
                ->setFirstName("Prénom $i")
                ->setLastName("Nom $i")
                ->setPhone("0606060000")
            ;

            $user->setEmail("customer+$i@gmail.com")
                ->setPassword($this->passwordHasher->hashPassword($user, "password"))
                ->setRoles([User::ROLE_CUSTOMER]);

            $manager->persist($customer);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Customer;
use App\Entity\Delivery;
use App\Entity\Discount;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DeliveryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $delivery = new Delivery();

            $delivery->setTitle("Methode $i")
                ->setPrice(($i + 1) * 3)
                ->setEnabled(true)
            ;

            $manager->persist($delivery);
        }

        $manager->flush();
    }
}

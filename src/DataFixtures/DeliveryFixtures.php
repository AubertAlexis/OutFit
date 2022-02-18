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
        $deliveries = array (
            array("Standard","Rapide","Express"),
            array(3,7,12),
        );
        for ($i = 0; $i < 3; $i++) {
            $delivery = new Delivery();

            $delivery->setTitle($deliveries[0][$i])
                ->setPrice($deliveries[1][$i])
                ->setEnabled(true)
            ;

            $manager->persist($delivery);
        }

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DiscountFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            $discount = new Discount();

            $discount->setType(Discount::PERCENT)
                ->setAmount(($i+1)*10)
                ->setEnabled(true)
            ;

            $manager->persist($discount);
        }

        $manager->flush();
    }
}

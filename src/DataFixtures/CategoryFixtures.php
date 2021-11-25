<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $category = new Category();

            $category->setTitle("Categorie $i")
                ->setEnabled(true)
            ;

            $manager->persist($category);
        }

        $manager->flush();
    }
}

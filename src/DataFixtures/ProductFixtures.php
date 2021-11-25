<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Customer;
use App\Entity\Discount;
use App\Entity\Product;
use App\Entity\Size;
use App\Entity\Stock;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sizeGlobal = new Size();
        $colorGlobal = new Color();

        //SIZE
        foreach ($this->getSizes() as $sizeName) {
            $size = new Size();
            $size->setTitle($sizeName);

            $sizeGlobal = $size;

            $manager->persist($size);
        }

        // COLOR
        foreach ($this->getColors() as $colorData) {
            $color = new Color();

            $color->setTitle($colorData[0])
                ->setHexa($colorData[1])
            ;

            $colorGlobal = $color;

            $manager->persist($color);
        }

        for ($i = 0; $i < 3; $i++) {
            $category = new Category();

            $category->setTitle("Categorie $i")
                ->setEnabled(true)
            ;

            $manager->persist($category);
        }

        for ($i = 0; $i < 5; $i++) {
            $product = new Product();

            $product->setEnabled(true)
                ->setName("Produit $i")
                ->setPrice(($i+1*7))
                ->addCategory(
                    (new Category())->setEnabled(true)
                    ->setTitle("ADZD")
                )
                ->addStock(
                    (new Stock())->setEnabled(true)
                        ->setProduct(null)
                        ->setSize($sizeGlobal)
                        ->setColor($colorGlobal)
                        ->setQuantity(($i+1)*100)
                );

            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * @return array<string>
     */
    private function getSizes(): array
    {
        return [
            "S",
            "M",
            "L",
            "XL",
            "2XL",
        ];
    }

    /**
     * @return string[][]
     */
    private function getColors(): array
    {
        return [
            ["Rouge", "#FF0000"],
            ["Jaune", "#FFFF00"],
            ["Bleu", "#0080FF"]
        ];
    }
}

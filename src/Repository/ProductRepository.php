<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return int|mixed|string
     */
//    public function findProductList()
//    {
//        return $this->createQueryBuilder('p')
//            ->select('p.id', 'p.name', 'p.price', )
//            ->join('p.stocks', 's')
//            ->join('s.color', 'c')
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}

<?php

declare(strict_types=1);

namespace App\Repository\Order;

use App\Entity\Order\Line;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Line::class);
    }
}

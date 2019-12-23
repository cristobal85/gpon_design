<?php

namespace App\Repository;

use App\Entity\WirePattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WirePattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method WirePattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method WirePattern[]    findAll()
 * @method WirePattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WirePatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WirePattern::class);
    }

    // /**
    //  * @return WirePattern[] Returns an array of WirePattern objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WirePattern
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\FiberPattern;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FiberPattern|null find($id, $lockMode = null, $lockVersion = null)
 * @method FiberPattern|null findOneBy(array $criteria, array $orderBy = null)
 * @method FiberPattern[]    findAll()
 * @method FiberPattern[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiberPatternRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FiberPattern::class);
    }

    // /**
    //  * @return FiberPattern[] Returns an array of FiberPattern objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FiberPattern
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

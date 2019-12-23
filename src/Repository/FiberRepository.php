<?php

namespace App\Repository;

use App\Entity\Fiber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fiber|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiber|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiber[]    findAll()
 * @method Fiber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiber::class);
    }

    // /**
    //  * @return Fiber[] Returns an array of Fiber objects
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
    public function findOneBySomeField($value): ?Fiber
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

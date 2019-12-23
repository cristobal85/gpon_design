<?php

namespace App\Repository;

use App\Entity\LatiguilloPatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LatiguilloPatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method LatiguilloPatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method LatiguilloPatch[]    findAll()
 * @method LatiguilloPatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LatiguilloPatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LatiguilloPatch::class);
    }

    // /**
    //  * @return LatiguilloPatch[] Returns an array of LatiguilloPatch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LatiguilloPatch
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Wire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Wire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wire[]    findAll()
 * @method Wire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wire::class);
    }

    // /**
    //  * @return Wire[] Returns an array of Wire objects
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
    public function findOneBySomeField($value): ?Wire
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

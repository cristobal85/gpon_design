<?php

namespace App\Repository;

use App\Entity\SubscriberBoxExt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBoxExt|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBoxExt|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBoxExt[]    findAll()
 * @method SubscriberBoxExt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxExtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBoxExt::class);
    }

    // /**
    //  * @return SubscriberBoxExt[] Returns an array of SubscriberBoxExt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubscriberBoxExt
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\SubscriberBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBox|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBox|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBox[]    findAll()
 * @method SubscriberBox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBox::class);
    }

    // /**
    //  * @return SubscriberBox[] Returns an array of SubscriberBox objects
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
    public function findOneBySomeField($value): ?SubscriberBox
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

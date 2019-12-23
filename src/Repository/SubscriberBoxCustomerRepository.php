<?php

namespace App\Repository;

use App\Entity\SubscriberBoxCustomer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBoxCustomer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBoxCustomer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBoxCustomer[]    findAll()
 * @method SubscriberBoxCustomer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxCustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBoxCustomer::class);
    }

    // /**
    //  * @return SubscriberBoxCustomer[] Returns an array of SubscriberBoxCustomer objects
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
    public function findOneBySomeField($value): ?SubscriberBoxCustomer
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

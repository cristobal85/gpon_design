<?php

namespace App\Repository;

use App\Entity\SubscriberBoxExtAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBoxExtAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBoxExtAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBoxExtAddress[]    findAll()
 * @method SubscriberBoxExtAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxExtAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBoxExtAddress::class);
    }

    // /**
    //  * @return SubscriberBoxExtAddress[] Returns an array of SubscriberBoxExtAddress objects
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
    public function findOneBySomeField($value): ?SubscriberBoxExtAddress
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

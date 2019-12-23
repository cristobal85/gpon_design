<?php

namespace App\Repository;

use App\Entity\SubscriberBoxExtImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBoxExtImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBoxExtImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBoxExtImage[]    findAll()
 * @method SubscriberBoxExtImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxExtImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBoxExtImage::class);
    }

    // /**
    //  * @return SubscriberBoxExtImage[] Returns an array of SubscriberBoxExtImage objects
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
    public function findOneBySomeField($value): ?SubscriberBoxExtImage
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

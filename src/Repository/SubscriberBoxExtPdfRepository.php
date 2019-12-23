<?php

namespace App\Repository;

use App\Entity\SubscriberBoxExtPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBoxExtPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBoxExtPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBoxExtPdf[]    findAll()
 * @method SubscriberBoxExtPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxExtPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBoxExtPdf::class);
    }

    // /**
    //  * @return SubscriberBoxExtPdf[] Returns an array of SubscriberBoxExtPdf objects
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
    public function findOneBySomeField($value): ?SubscriberBoxExtPdf
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

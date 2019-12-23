<?php

namespace App\Repository;

use App\Entity\SubscriberBoxPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SubscriberBoxPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriberBoxPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriberBoxPdf[]    findAll()
 * @method SubscriberBoxPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriberBoxPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriberBoxPdf::class);
    }

    // /**
    //  * @return SubscriberBoxPdf[] Returns an array of SubscriberBoxPdf objects
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
    public function findOneBySomeField($value): ?SubscriberBoxPdf
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

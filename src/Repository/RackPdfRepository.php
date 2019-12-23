<?php

namespace App\Repository;

use App\Entity\RackPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RackPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method RackPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method RackPdf[]    findAll()
 * @method RackPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RackPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RackPdf::class);
    }

    // /**
    //  * @return RackPdf[] Returns an array of RackPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RackPdf
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

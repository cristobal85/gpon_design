<?php

namespace App\Repository;

use App\Entity\DistributionBoxPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DistributionBoxPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistributionBoxPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistributionBoxPdf[]    findAll()
 * @method DistributionBoxPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributionBoxPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistributionBoxPdf::class);
    }

    // /**
    //  * @return DistributionBoxPdf[] Returns an array of DistributionBoxPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DistributionBoxPdf
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

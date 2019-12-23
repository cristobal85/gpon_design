<?php

namespace App\Repository;

use App\Entity\CpdPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CpdPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpdPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpdPdf[]    findAll()
 * @method CpdPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpdPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpdPdf::class);
    }

    // /**
    //  * @return CpdPdf[] Returns an array of CpdPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CpdPdf
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

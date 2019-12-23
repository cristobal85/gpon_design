<?php

namespace App\Repository;

use App\Entity\OltPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OltPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method OltPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method OltPdf[]    findAll()
 * @method OltPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OltPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OltPdf::class);
    }

    // /**
    //  * @return OltPdf[] Returns an array of OltPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OltPdf
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

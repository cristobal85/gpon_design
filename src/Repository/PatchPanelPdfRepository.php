<?php

namespace App\Repository;

use App\Entity\PatchPanelPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PatchPanelPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatchPanelPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatchPanelPdf[]    findAll()
 * @method PatchPanelPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatchPanelPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatchPanelPdf::class);
    }

    // /**
    //  * @return PatchPanelPdf[] Returns an array of PatchPanelPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PatchPanelPdf
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

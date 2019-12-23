<?php

namespace App\Repository;

use App\Entity\NodoPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NodoPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method NodoPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method NodoPdf[]    findAll()
 * @method NodoPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NodoPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NodoPdf::class);
    }

    // /**
    //  * @return NodoPdf[] Returns an array of NodoPdf objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NodoPdf
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

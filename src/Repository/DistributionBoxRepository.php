<?php

namespace App\Repository;

use App\Entity\DistributionBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DistributionBox|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistributionBox|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistributionBox[]    findAll()
 * @method DistributionBox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributionBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistributionBox::class);
    }

    // /**
    //  * @return DistributionBox[] Returns an array of DistributionBox objects
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
    public function findOneBySomeField($value): ?DistributionBox
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

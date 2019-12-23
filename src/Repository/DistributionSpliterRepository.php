<?php

namespace App\Repository;

use App\Entity\DistributionSpliter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DistributionSpliter|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistributionSpliter|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistributionSpliter[]    findAll()
 * @method DistributionSpliter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributionSpliterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistributionSpliter::class);
    }

    // /**
    //  * @return DistributionSpliter[] Returns an array of DistributionSpliter objects
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
    public function findOneBySomeField($value): ?DistributionSpliter
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

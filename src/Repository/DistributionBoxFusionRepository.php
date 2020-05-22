<?php

namespace App\Repository;

use App\Entity\DistributionBoxFusion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DistributionBoxFusion|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistributionBoxFusion|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistributionBoxFusion[]    findAll()
 * @method DistributionBoxFusion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributionBoxFusionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistributionBoxFusion::class);
    }

    // /**
    //  * @return DistributionBoxFusion[] Returns an array of DistributionBoxFusion objects
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
    public function findOneBySomeField($value): ?DistributionBoxFusion
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

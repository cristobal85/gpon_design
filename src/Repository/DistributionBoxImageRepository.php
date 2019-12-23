<?php

namespace App\Repository;

use App\Entity\DistributionBoxImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DistributionBoxImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistributionBoxImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistributionBoxImage[]    findAll()
 * @method DistributionBoxImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributionBoxImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistributionBoxImage::class);
    }

    // /**
    //  * @return DistributionBoxImage[] Returns an array of DistributionBoxImage objects
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
    public function findOneBySomeField($value): ?DistributionBoxImage
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

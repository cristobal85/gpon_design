<?php

namespace App\Repository;

use App\Entity\DistributionBoxPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DistributionBoxPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method DistributionBoxPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method DistributionBoxPort[]    findAll()
 * @method DistributionBoxPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistributionBoxPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DistributionBoxPort::class);
    }

    // /**
    //  * @return DistributionBoxPort[] Returns an array of DistributionBoxPort objects
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
    public function findOneBySomeField($value): ?DistributionBoxPort
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

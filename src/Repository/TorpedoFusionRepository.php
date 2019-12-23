<?php

namespace App\Repository;

use App\Entity\TorpedoFusion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TorpedoFusion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TorpedoFusion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TorpedoFusion[]    findAll()
 * @method TorpedoFusion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TorpedoFusionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TorpedoFusion::class);
    }

    // /**
    //  * @return TorpedoFusion[] Returns an array of TorpedoFusion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TorpedoFusion
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

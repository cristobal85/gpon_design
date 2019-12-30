<?php

namespace App\Repository;

use App\Entity\TorpedoPassant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TorpedoPassant|null find($id, $lockMode = null, $lockVersion = null)
 * @method TorpedoPassant|null findOneBy(array $criteria, array $orderBy = null)
 * @method TorpedoPassant[]    findAll()
 * @method TorpedoPassant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TorpedoPassantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TorpedoPassant::class);
    }

    // /**
    //  * @return TorpedoPassant[] Returns an array of TorpedoPassant objects
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
    public function findOneBySomeField($value): ?TorpedoPassant
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

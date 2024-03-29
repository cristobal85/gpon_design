<?php

namespace App\Repository;

use App\Entity\Torpedo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Torpedo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Torpedo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Torpedo[]    findAll()
 * @method Torpedo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TorpedoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Torpedo::class);
    }

    // /**
    //  * @return Torpedo[] Returns an array of Torpedo objects
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
    public function findOneBySomeField($value): ?Torpedo
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

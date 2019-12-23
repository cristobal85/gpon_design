<?php

namespace App\Repository;

use App\Entity\Tube;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Tube|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tube|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tube[]    findAll()
 * @method Tube[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TubeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tube::class);
    }

    // /**
    //  * @return Tube[] Returns an array of Tube objects
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
    public function findOneBySomeField($value): ?Tube
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

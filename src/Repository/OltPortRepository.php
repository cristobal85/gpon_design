<?php

namespace App\Repository;

use App\Entity\OltPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OltPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method OltPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method OltPort[]    findAll()
 * @method OltPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OltPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OltPort::class);
    }

    // /**
    //  * @return OltPort[] Returns an array of OltPort objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OltPort
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

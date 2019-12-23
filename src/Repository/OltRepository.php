<?php

namespace App\Repository;

use App\Entity\Olt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Olt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Olt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Olt[]    findAll()
 * @method Olt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OltRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Olt::class);
    }

    // /**
    //  * @return Olt[] Returns an array of Olt objects
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
    public function findOneBySomeField($value): ?Olt
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

<?php

namespace App\Repository;

use App\Entity\Edfa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Edfa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Edfa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Edfa[]    findAll()
 * @method Edfa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdfaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edfa::class);
    }

    // /**
    //  * @return Edfa[] Returns an array of Edfa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Edfa
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Nodo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Nodo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nodo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nodo[]    findAll()
 * @method Nodo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NodoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nodo::class);
    }

    // /**
    //  * @return Nodo[] Returns an array of Nodo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Nodo
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

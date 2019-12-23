<?php

namespace App\Repository;

use App\Entity\EdfaPdf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EdfaPdf|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdfaPdf|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdfaPdf[]    findAll()
 * @method EdfaPdf[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdfaPdfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdfaPdf::class);
    }

    // /**
    //  * @return EdfaPdf[] Returns an array of EdfaPdf objects
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
    public function findOneBySomeField($value): ?EdfaPdf
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

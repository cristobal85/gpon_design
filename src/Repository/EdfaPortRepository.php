<?php

namespace App\Repository;

use App\Entity\EdfaPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EdfaPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdfaPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdfaPort[]    findAll()
 * @method EdfaPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdfaPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdfaPort::class);
    }

    // /**
    //  * @return EdfaPort[] Returns an array of EdfaPort objects
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
    public function findOneBySomeField($value): ?EdfaPort
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

<?php

namespace App\Repository;

use App\Entity\EdfaSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EdfaSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdfaSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdfaSlot[]    findAll()
 * @method EdfaSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdfaSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdfaSlot::class);
    }

    // /**
    //  * @return EdfaSlot[] Returns an array of EdfaSlot objects
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
    public function findOneBySomeField($value): ?EdfaSlot
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

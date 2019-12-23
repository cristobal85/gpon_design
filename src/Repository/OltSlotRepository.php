<?php

namespace App\Repository;

use App\Entity\OltSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OltSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method OltSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method OltSlot[]    findAll()
 * @method OltSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OltSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OltSlot::class);
    }

    // /**
    //  * @return OltSlot[] Returns an array of OltSlot objects
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
    public function findOneBySomeField($value): ?OltSlot
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

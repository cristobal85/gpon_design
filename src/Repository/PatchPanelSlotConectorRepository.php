<?php

namespace App\Repository;

use App\Entity\PatchPanelSlotConector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SlotConector|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlotConector|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlotConector[]    findAll()
 * @method SlotConector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatchPanelSlotConectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatchPanelSlotConector::class);
    }

    // /**
    //  * @return SlotConector[] Returns an array of SlotConector objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SlotConector
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

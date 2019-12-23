<?php

namespace App\Repository;

use App\Entity\PatchPanel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PathPanel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PathPanel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PathPanel[]    findAll()
 * @method PathPanel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatchPanelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatchPanel::class);
    }

    // /**
    //  * @return PathPanel[] Returns an array of PathPanel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PathPanel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

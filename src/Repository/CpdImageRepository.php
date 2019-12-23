<?php

namespace App\Repository;

use App\Entity\CpdImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CpdImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method CpdImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method CpdImage[]    findAll()
 * @method CpdImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CpdImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CpdImage::class);
    }

    // /**
    //  * @return CpdImage[] Returns an array of CpdImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CpdImage
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

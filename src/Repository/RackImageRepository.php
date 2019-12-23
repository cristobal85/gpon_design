<?php

namespace App\Repository;

use App\Entity\RackImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RackImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method RackImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method RackImage[]    findAll()
 * @method RackImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RackImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RackImage::class);
    }

    // /**
    //  * @return RackImage[] Returns an array of RackImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RackImage
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

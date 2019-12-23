<?php

namespace App\Repository;

use App\Entity\OltImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OltImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method OltImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method OltImage[]    findAll()
 * @method OltImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OltImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OltImage::class);
    }

    // /**
    //  * @return OltImage[] Returns an array of OltImage objects
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
    public function findOneBySomeField($value): ?OltImage
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

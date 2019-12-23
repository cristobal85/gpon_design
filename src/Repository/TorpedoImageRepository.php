<?php

namespace App\Repository;

use App\Entity\TorpedoImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TorpedoImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TorpedoImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TorpedoImage[]    findAll()
 * @method TorpedoImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TorpedoImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TorpedoImage::class);
    }

    // /**
    //  * @return TorpedoImage[] Returns an array of TorpedoImage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TorpedoImage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

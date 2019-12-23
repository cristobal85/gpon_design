<?php

namespace App\Repository;

use App\Entity\EdfaImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EdfaImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdfaImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdfaImage[]    findAll()
 * @method EdfaImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdfaImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdfaImage::class);
    }

    // /**
    //  * @return EdfaImage[] Returns an array of EdfaImage objects
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
    public function findOneBySomeField($value): ?EdfaImage
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

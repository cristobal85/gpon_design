<?php

namespace App\Repository;

use App\Entity\PatchPanelImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PatchPanelImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatchPanelImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatchPanelImage[]    findAll()
 * @method PatchPanelImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatchPanelImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatchPanelImage::class);
    }

    // /**
    //  * @return PatchPanelImage[] Returns an array of PatchPanelImage objects
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
    public function findOneBySomeField($value): ?PatchPanelImage
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

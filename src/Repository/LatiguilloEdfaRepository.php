<?php

namespace App\Repository;

use App\Entity\LatiguilloEdfa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LatiguilloEdfa|null find($id, $lockMode = null, $lockVersion = null)
 * @method LatiguilloEdfa|null findOneBy(array $criteria, array $orderBy = null)
 * @method LatiguilloEdfa[]    findAll()
 * @method LatiguilloEdfa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LatiguilloEdfaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LatiguilloEdfa::class);
    }

    // /**
    //  * @return LatiguilloEdfa[] Returns an array of LatiguilloEdfa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LatiguilloEdfa
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

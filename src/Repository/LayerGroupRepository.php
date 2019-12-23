<?php

namespace App\Repository;

use App\Entity\LayerGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LayerGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method LayerGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method LayerGroup[]    findAll()
 * @method LayerGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LayerGroupRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, LayerGroup::class);
    }

    // /**
    //  * @return LayerGroup[] Returns an array of LayerGroup objects
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
      public function findOneBySomeField($value): ?LayerGroup
      {
      return $this->createQueryBuilder('l')
      ->andWhere('l.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */

    public function findAllToArray() {
//        $query = $this->getDoctrine()
//                ->getRepository('CoreBundle:Categories')
//                ->createQueryBuilder('c')
//                ->getQuery();
//        $result = $query->getResult(Query::HYDRATE_ARRAY);
        
        $qb = $this->createQueryBuilder('l')
            ->getQuery();

        return $qb->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }

}

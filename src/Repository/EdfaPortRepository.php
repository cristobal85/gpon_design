<?php

namespace App\Repository;

use App\Entity\EdfaPort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\Edfa;

/**
 * @method EdfaPort|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdfaPort|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdfaPort[]    findAll()
 * @method EdfaPort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdfaPortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdfaPort::class);
    }

    /**
     * @return EdfaPort 
     */
    public function findOneByNumberAndSlotType(Edfa $edfa, string $number, string $slotType)
    {
        return $this->createQueryBuilder("edfaPort")
            ->join("edfaPort.edfaSlot", 'edfaSlot')
            ->join("edfaSlot.edfa", 'edfa')
            ->andWhere('edfaPort.number = :number')
            ->andWhere('edfaSlot.type = :slotType')
            ->andWhere('edfa = :edfa')
            ->setParameter('number', intval($number))
            ->setParameter('slotType', $slotType)
            ->setParameter('edfa', $edfa)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?EdfaPort
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

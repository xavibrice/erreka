<?php

namespace App\Repository;

use App\Entity\Visit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Visit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Visit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Visit[]    findAll()
 * @method Visit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Visit::class);
    }

    public function findBySell($getAgency)
    {
        return $this->createQueryBuilder('v')
            ->innerJoin('v.client', 'c')
            ->innerJoin('v.property', 'p')
            ->andWhere('p.agency = :agency')
            ->andWhere('c.sellOrRent = :sell')
            ->setParameter('agency', $getAgency)
            ->setParameter('sell', true)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByRent($getAgency)
    {
        return $this->createQueryBuilder('v')
            ->innerJoin('v.client', 'c')
            ->innerJoin('v.property', 'p')
            ->andWhere('p.agency = :agency')
            ->andWhere('c.sellOrRent = :sell')
            ->setParameter('agency', $getAgency)
            ->setParameter('sell', false)
            ->orderBy('v.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?Visit
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

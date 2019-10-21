<?php

namespace App\Repository;

use App\Entity\ValuationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ValuationStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ValuationStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ValuationStatus[]    findAll()
 * @method ValuationStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValuationStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ValuationStatus::class);
    }

    // /**
    //  * @return ValuationStatus[] Returns an array of ValuationStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ValuationStatus
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

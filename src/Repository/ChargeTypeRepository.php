<?php

namespace App\Repository;

use App\Entity\ChargeType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChargeType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChargeType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChargeType[]    findAll()
 * @method ChargeType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargeTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChargeType::class);
    }


    public function findExclusive()
    {
        return $this->createQueryBuilder('ct')
            ->andWhere('ct.name = :name')
            ->innerJoin('ct.charges', 'c')
            ->innerJoin('c.rate_housing', 'rh')
            ->innerJoin('rh.property', 'p')
            ->innerJoin('p.propertyReductions', 'pr')
            ->select(['SUM(pr.price) as sumPropertyReduction', 'ct', 'c', 'rh', 'p', 'pr'])
            ->setParameter('name', 'Exclusiva')
            ->getQuery()
            ->getResult()
            ;
    }


    // /**
    //  * @return ChargeType[] Returns an array of ChargeType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChargeType
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

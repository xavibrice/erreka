<?php

namespace App\Repository;

use App\Entity\ChargeType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ChargeType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChargeType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChargeType[]    findAll()
 * @method ChargeType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChargeTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ChargeType::class);
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

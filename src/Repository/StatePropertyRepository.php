<?php

namespace App\Repository;

use App\Entity\StateProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StateProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method StateProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method StateProperty[]    findAll()
 * @method StateProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatePropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, StateProperty::class);
    }

    // /**
    //  * @return StateProperty[] Returns an array of StateProperty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StateProperty
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

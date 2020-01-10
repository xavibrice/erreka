<?php

namespace App\Repository;

use App\Entity\Ground;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ground|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ground|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ground[]    findAll()
 * @method Ground[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroundRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ground::class);
    }

    // /**
    //  * @return Ground[] Returns an array of Ground objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ground
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

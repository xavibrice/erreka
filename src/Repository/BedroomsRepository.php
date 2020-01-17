<?php

namespace App\Repository;

use App\Entity\Bedrooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bedrooms|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bedrooms|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bedrooms[]    findAll()
 * @method Bedrooms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BedroomsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bedrooms::class);
    }

    // /**
    //  * @return Bedrooms[] Returns an array of Bedrooms objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bedrooms
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

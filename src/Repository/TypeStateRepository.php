<?php

namespace App\Repository;

use App\Entity\TypeState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeState|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeState|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeState[]    findAll()
 * @method TypeState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeState::class);
    }

    // /**
    //  * @return TypeState[] Returns an array of TypeState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeState
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

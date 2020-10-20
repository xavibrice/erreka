<?php

namespace App\Repository;

use App\Entity\TypeStorageRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeStorageRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeStorageRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeStorageRoom[]    findAll()
 * @method TypeStorageRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeStorageRoomRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TypeStorageRoom::class);
    }

    // /**
    //  * @return TypeStorageRoom[] Returns an array of TypeStorageRoom objects
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
    public function findOneBySomeField($value): ?TypeStorageRoom
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

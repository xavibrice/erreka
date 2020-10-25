<?php

namespace App\Repository;

use App\Entity\StorageRoomLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method StorageRoomLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method StorageRoomLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method StorageRoomLocation[]    findAll()
 * @method StorageRoomLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StorageRoomLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StorageRoomLocation::class);
    }

    // /**
    //  * @return StorageRoomLocation[] Returns an array of StorageRoomLocation objects
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
    public function findOneBySomeField($value): ?StorageRoomLocation
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

<?php

namespace App\Repository;

use App\Entity\Door;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Door|null find($id, $lockMode = null, $lockVersion = null)
 * @method Door|null findOneBy(array $criteria, array $orderBy = null)
 * @method Door[]    findAll()
 * @method Door[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Door::class);
    }

    // /**
    //  * @return Door[] Returns an array of Door objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Door
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

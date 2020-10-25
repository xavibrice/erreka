<?php

namespace App\Repository;

use App\Entity\Offered;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Offered|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offered|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offered[]    findAll()
 * @method Offered[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offered::class);
    }

    // /**
    //  * @return Offered[] Returns an array of Offered objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Offered
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

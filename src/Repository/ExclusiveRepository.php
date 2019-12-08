<?php

namespace App\Repository;

use App\Entity\Exclusive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Exclusive|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exclusive|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exclusive[]    findAll()
 * @method Exclusive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExclusiveRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Exclusive::class);
    }

    // /**
    //  * @return Exclusive[] Returns an array of Exclusive objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exclusive
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\Situation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Situation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Situation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Situation[]    findAll()
 * @method Situation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SituationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Situation::class);
    }

    // /**
    //  * @return Situation[] Returns an array of Situation objects
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
    public function findOneBySomeField($value): ?Situation
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

<?php

namespace App\Repository;

use App\Entity\TypeGarage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TypeGarage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeGarage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeGarage[]    findAll()
 * @method TypeGarage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeGarageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeGarage::class);
    }

    // /**
    //  * @return TypeGarage[] Returns an array of TypeGarage objects
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
    public function findOneBySomeField($value): ?TypeGarage
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

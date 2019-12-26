<?php

namespace App\Repository;

use App\Entity\PropertyReduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PropertyReduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyReduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyReduction[]    findAll()
 * @method PropertyReduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyReductionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PropertyReduction::class);
    }

    public function sumPropertyReduction($id)
    {
        return $this->createQueryBuilder('pr')
            ->andWhere('pr.property = :id')
            ->select('SUM(pr.price) as sumPropertyReduction')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

    // /**
    //  * @return PropertyReduction[] Returns an array of PropertyReduction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PropertyReduction
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

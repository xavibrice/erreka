<?php

namespace App\Repository;

use App\Entity\BuildingStructure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BuildingStructure|null find($id, $lockMode = null, $lockVersion = null)
 * @method BuildingStructure|null findOneBy(array $criteria, array $orderBy = null)
 * @method BuildingStructure[]    findAll()
 * @method BuildingStructure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildingStructureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BuildingStructure::class);
    }

    // /**
    //  * @return BuildingStructure[] Returns an array of BuildingStructure objects
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
    public function findOneBySomeField($value): ?BuildingStructure
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

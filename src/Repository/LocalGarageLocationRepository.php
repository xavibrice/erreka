<?php

namespace App\Repository;

use App\Entity\LocalGarageLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LocalGarageLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocalGarageLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocalGarageLocation[]    findAll()
 * @method LocalGarageLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalGarageLocationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LocalGarageLocation::class);
    }

    // /**
    //  * @return LocalGarageLocation[] Returns an array of LocalGarageLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LocalGarageLocation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

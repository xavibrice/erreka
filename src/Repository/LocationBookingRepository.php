<?php

namespace App\Repository;

use App\Entity\LocationBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LocationBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method LocationBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method LocationBooking[]    findAll()
 * @method LocationBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationBookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LocationBooking::class);
    }

    // /**
    //  * @return LocationBooking[] Returns an array of LocationBooking objects
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
    public function findOneBySomeField($value): ?LocationBooking
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

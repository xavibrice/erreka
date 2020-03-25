<?php

namespace App\Repository;

use App\Entity\TitleBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TitleBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method TitleBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method TitleBooking[]    findAll()
 * @method TitleBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitleBookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TitleBooking::class);
    }

    // /**
    //  * @return TitleBooking[] Returns an array of TitleBooking objects
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
    public function findOneBySomeField($value): ?TitleBooking
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

<?php

namespace App\Repository;

use App\Entity\Street;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Street|null find($id, $lockMode = null, $lockVersion = null)
 * @method Street|null findOneBy(array $criteria, array $orderBy = null)
 * @method Street[]    findAll()
 * @method Street[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Street::class);
    }

    public function findByStreet($zone_id)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.zone = :zone')
            ->setParameter('zone', $zone_id)
            ->getQuery()
            ->getArrayResult()
            ;
    }

    // /**
    //  * @return Street[] Returns an array of Street objects
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
    public function findOneBySomeField($value): ?Street
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

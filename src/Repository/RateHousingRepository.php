<?php

namespace App\Repository;


use App\Entity\RateHousing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RateHousing|null find($id, $lockMode = null, $lockVersion = null)
 * @method RateHousing|null findOneBy(array $criteria, array $orderBy = null)
 * @method RateHousing[]    findAll()
 * @method RateHousing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RateHousingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RateHousing::class);
    }

    public function findByAgency($getAgency)
    {
        return $this->createQueryBuilder('rh')
            ->innerJoin('rh.property', 'p')
            ->innerJoin('p.agency', 'a')
            ->andWhere('a.name = :agency')
            ->setParameter('agency', $getAgency)
            ->getQuery()
            ->getResult()
        ;
    }


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

<?php

namespace App\Repository;

use App\Entity\ClientStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClientStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientStatus[]    findAll()
 * @method ClientStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientStatus::class);
    }

    // /**
    //  * @return ClientStatus[] Returns an array of ClientStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientStatus
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAgencyStatus($getAgency)
    {
        return $this->createQueryBuilder('cs')
            ->innerJoin('cs.client', 'cli')
            ->innerJoin('cli.commercial', 'com')
            ->andWhere('com.agency = :agency')
            ->setParameter('agency', $getAgency)
            ->getQuery()
            ->getResult()
            ;
    }
}

<?php

namespace App\Repository;

use App\Entity\EnergyCertificate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EnergyCertificate|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnergyCertificate|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnergyCertificate[]    findAll()
 * @method EnergyCertificate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnergyCertificateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyCertificate::class);
    }

    // /**
    //  * @return EnergyCertificate[] Returns an array of EnergyCertificate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnergyCertificate
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

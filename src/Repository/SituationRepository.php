<?php

namespace App\Repository;

use App\Entity\Situation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Situation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Situation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Situation[]    findAll()
 * @method Situation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SituationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Situation::class);
    }

    public function propertyForSituation(string $situation, $commercial)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.reason', 'r')
            ->innerJoin('r.properties', 'p')
            ->andWhere('p.enabled = :state')
            ->andWhere('p.commercial = :commercial')
            ->andWhere('s.name_slug = :situation')
            ->setParameter('state', true)
            ->setParameter('situation', $situation)
            ->setParameter('commercial', $commercial)
            ->getQuery()
            ->getResult()
            ;
    }

//    public function newForSituation(string $situation, $user = null)
//    {
//        return $this->createQueryBuilder('n')
//            ->innerJoin('n.reason', 'r')
//            ->innerJoin('r.situation', 's')
//            ->andWhere('s.name_slug = :situation')
//            ->andWhere('n.state = :state')
//            ->andWhere('n.commercial = :commercial')
//            ->setParameter('state', true)
//            ->setParameter('situation', $situation)
//            ->setParameter('commercial', $user)
//            ->getQuery()
//            ->getResult()
//            ;
//    }


    // /**
    //  * @return Situation[] Returns an array of Situation objects
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
    public function findOneBySomeField($value): ?Situation
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

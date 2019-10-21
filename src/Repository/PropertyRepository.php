<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
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
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function propertyForSituation($situation, $getUser)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('s.name_slug = :situation')
            ->andWhere('p.commercial = :commercial')
            ->setParameter('enabled', true)
            ->setParameter('situation', $situation)
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult()
            ;

    }

    public function chargeForSituation($charge, $property, $getUser)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.stateProperty', 'sp')
            ->innerJoin('p.typeProperty', 'tp')
            ->andWhere('sp.name = :stateProperty')
            ->andWhere('tp.name_slug = :typeProperty')
            ->andWhere('p.commercial = :commercial')
            ->setParameter('typeProperty', $property)
            ->setParameter('stateProperty', $charge)
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult()
            ;
    }


/*    public function propertyForSituation(string $situation, $commercial)
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
    }*/

}

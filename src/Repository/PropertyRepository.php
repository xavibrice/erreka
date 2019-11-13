<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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

    /*public function onlyNotices($getUser)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('s.name != :situation')
            ->andWhere('p.commercial = :commercial')
            ->orderBy('p.created', 'DESC')
            ->setParameter('enabled', true)
            ->setParameter('situation', 'noticia a desarrollar')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult()
            ;
    }*/

    public function onlyNotices($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name != :situation')
            ->setParameter('situation', 'noticia a desarrollar')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();
    }

    public function onlyNoticesToDeveloper($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'noticia a desarrollar')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();
    }

    private function addAllNoticesQueryBuilder(QueryBuilder $qb = null)
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.commercial = :commercial')
            ->orderBy('p.created', 'DESC')
            ->setParameter('enabled', true);
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('p');
    }
}

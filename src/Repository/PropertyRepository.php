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

    public function onlyNotices($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'Noticia')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();
    }

    public function alertsOnlyNotices($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->innerJoin('p.note_new', 'nn')
            ->andWhere('nn.next_call = :next_call')
            ->setParameter('situation', 'Noticia')
            ->setParameter('commercial', $getUser)
            ->setParameter('next_call', new \DateTime())
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

    public function alertsOnlyNoticesToDeveloper($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->innerJoin('p.note_new', 'nn')
            ->andWhere('nn.next_call = :next_call')
            ->setParameter('situation', 'noticia a desarrollar')
            ->setParameter('next_call', new \DateTime())
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();
    }

    public function onlyExclusives($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('c.charge_type', 'ct')
            ->andWhere('ct.name = :chargeType')
            ->setParameter('situation', 'Noticia')
            ->setParameter('chargeType', 'Exclusiva')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();
    }

    public function onlyAuthorization($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('c.charge_type', 'ct')
            ->andWhere('ct.name = :chargeType')
            ->setParameter('situation', 'Noticia')
            ->setParameter('chargeType', 'Autorización')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();
    }

    public function alertsOnlyCharges($getUser)
    {
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('c.charge_type', 'ct')
            ->innerJoin('p.note_new', 'nn')
            ->andWhere('nn.next_call = :next_call')
            ->andWhere('ct.name = :chargeType OR ct.name = :chargeExclusive')
            ->setParameter('situation', 'Noticia')
            ->setParameter('chargeType', 'Autorización')
            ->setParameter('chargeExclusive', 'Exclusiva')
            ->setParameter('next_call', new \DateTime())
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

    public function findAllMatching(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.street LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}

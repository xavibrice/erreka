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

    public function onlyNoticesAdmin($getAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('p.agency', 'a')
            ->innerJoin('r.situation', 's')
            ->andWhere('s.name = :situation')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('a.name = :agency')
            ->orderBy('p.created', 'DESC')
            ->setParameter('agency', $getAgency)
            ->setParameter('enabled', true)
            ->setParameter('situation', 'Noticia')
            ->getQuery()
            ->getResult();
    }

    public function onlyNotices($getAgency, $getUser)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('p.agency', 'a')
            ->innerJoin('r.situation', 's')
            ->andWhere('s.name = :situation')
            ->andWhere('p.commercial = :commercial')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('a.name = :agency')
            ->orderBy('p.created', 'DESC')
            ->setParameter('agency', $getAgency)
            ->setParameter('commercial', $getUser)
            ->setParameter('enabled', true)
            ->setParameter('situation', 'Noticia')
            ->getQuery()
            ->getResult();


//        return $this->addAllNoticesQueryBuilder()
//            ->andWhere('s.name = :situation')
//            ->setParameter('situation', 'Noticia')
//            ->setParameter('commercial', $getUser)
//            ->getQuery()
//            ->getResult();
    }

    public function alertsOnlyNotices($getUser, $getAgency)
    {
//        $datetime = new \DateTime();
//        $date = $datetime->format('Y-m-d');
//        return $this->addAllNoticesQueryBuilder()
//            ->andWhere('s.name = :situation')
//            ->andWhere('p.next_call <= :nexCall')
//            ->setParameter('situation', 'Noticia')
//            ->setParameter('commercial', $getUser)
//            ->getQuery()
//            ->getResult();

        $datetime = new \DateTime();
        $date = $datetime->format('Y-m-d');
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.commercial = :commercial')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.next_call <= :nexCall')
            ->andWhere('s.name = :situation OR r.name = :rent')
            ->setParameter('nexCall', $date)
            ->setParameter('enabled', true)
            ->setParameter('commercial', $getUser)
            ->setParameter('situation', 'noticia')
            ->setParameter('rent', 'alquilado')
            ->getQuery()
            ->getResult()
            ;
    }

    public function onlyNoticesToDeveloper($getAgency, $getUser)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('p.agency', 'a')
            ->innerJoin('r.situation', 's')
            ->andWhere('s.name = :situation')
            ->andWhere('p.commercial = :commercial')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('a.name = :agency')
            ->orderBy('p.created', 'DESC')
            ->setParameter('agency', $getAgency)
            ->setParameter('commercial', $getUser)
            ->setParameter('enabled', true)
            ->setParameter('situation', 'noticia a desarrollar')
            ->getQuery()
            ->getResult();
/*        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'noticia a desarrollar')
            ->setParameter('commercial', $getUser)
            ->getQuery()
            ->getResult();*/
    }

    public function onlyNoticesToDeveloperAdmin($getAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('p.agency', 'a')
            ->innerJoin('r.situation', 's')
            ->andWhere('s.name = :situation')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('a.name = :agency')
            ->orderBy('p.created', 'DESC')
            ->setParameter('agency', $getAgency)
            ->setParameter('enabled', true)
            ->setParameter('situation', 'noticia a desarrollar')
            ->getQuery()
            ->getResult();
    }

    public function onlyCharges($getAgency) {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.charge', 'c')
            ->leftJoin('p.propertyReductions', 'pr')
            ->addSelect('SUM(pr.price) as sumPropertyReduction')
            ->andWhere('p.agency = :agency')
            ->setParameter('agency', $getAgency)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    public function onlyExclusives($getAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.agency', 'a')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('c.charge_type', 'ct')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('a.name = :agency')
            ->andWhere('ct.name = :chargeType')
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'Noticia')
            ->setParameter('chargeType', 'Exclusiva')
            ->setParameter('agency', $getAgency)
            ->getQuery()
            ->getResult();
//        return $this->addAllNoticesQueryBuilder()
//            ->andWhere('s.name = :situation')
//            ->innerJoin('p.charge', 'c')
//            ->innerJoin('c.charge_type', 'ct')
//            ->andWhere('ct.name = :chargeType')
//            ->setParameter('situation', 'Noticia')
//            ->setParameter('chargeType', 'Exclusiva')
//            ->setParameter('commercial', $getUser)
//            ->getQuery()
//            ->getResult();
    }

    public function onlyAuthorization($getAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.agency', 'a')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('c.charge_type', 'ct')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('a.name = :agency')
            ->andWhere('ct.name = :chargeType')
            ->andWhere('s.name = :situation')
            ->setParameter('situation', 'Noticia')
            ->setParameter('chargeType', 'Autorización')
            ->setParameter('agency', $getAgency)
            ->getQuery()
            ->getResult();
//        return $this->addAllNoticesQueryBuilder()
//            ->andWhere('s.name = :situation')
//            ->innerJoin('p.charge', 'c')
//            ->innerJoin('c.charge_type', 'ct')
//            ->andWhere('ct.name = :chargeType')
//            ->setParameter('situation', 'Noticia')
//            ->setParameter('chargeType', 'Autorización')
//            ->setParameter('commercial', $getUser)
//            ->getQuery()
//            ->getResult();
    }

    public function alertsOnlyCharges($getUser)
    {
        $datetime = new \DateTime();
        $date = $datetime->format('Y-m-d');
        return $this->addAllNoticesQueryBuilder()
            ->andWhere('s.name = :situation')
            ->innerJoin('p.charge', 'c')
            ->innerJoin('c.charge_type', 'ct')
            ->andWhere('p.next_call <= :nextCall')
            ->andWhere('ct.name = :chargeType OR ct.name = :chargeExclusive')
            ->setParameter('nextCall', $date)
            ->setParameter('situation', 'Noticia')
            ->setParameter('chargeType', 'Autorización')
            ->setParameter('chargeExclusive', 'Exclusiva')
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

    public function alertsOnlyNoticesToDeveloper($getUser)
    {
        $datetime = new \DateTime();
        $date = $datetime->format('Y-m-d');
        return $this->createQueryBuilder('p')
            ->innerJoin('p.note_new', 'nn')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('p.commercial = :commercial')
            ->andWhere('p.enabled = :enabled')
            ->andWhere('p.next_call <= :nexCall')
            ->andWhere('s.name = :situation')
            ->setParameter('nexCall', $date)
            ->setParameter('enabled', true)
            ->setParameter('commercial', $getUser)
            ->setParameter('situation', 'noticia a desarrollar')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findFullStreet(string $data)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.street', 's')
            ->andWhere('(s.name LIKE :street OR p.portal LIKE :portal OR p.floor LIKE :floor)')
            ->setParameter('street', '%'.$data.'%')
            ->setParameter('portal', '%'.$data.'%')
            ->setParameter('floor', '%'.$data.'%')
            ->getQuery()
            ->execute()
            ;
    }

    public function findAllMatching(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.street', 's')
            ->andWhere('(s.name LIKE :street OR p.portal LIKE :portal OR p.floor LIKE :floor)')
            ->setParameter('street', '%'.$query.'%')
            ->setParameter('portal', '%'.$query.'%')
            ->setParameter('floor', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }

    public function onlyRented($getAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.commercial', 'c')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('c.agency', 'a')
            ->andWhere('a.name = :agency')
            ->andWhere('r.name = :reason')
            ->setParameter('agency', $getAgency)
            ->setParameter('reason', 'alquilado')
            ->getQuery()
            ->getResult()
            ;
    }

    public function onlyHistorical($getAgency)
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.commercial', 'c')
            ->innerJoin('p.reason', 'r')
            ->innerJoin('c.agency', 'a')
            ->andWhere('a.name = :agency')
            ->andWhere('r.name = :reason')
            ->setParameter('agency', $getAgency)
            ->setParameter('reason', 'eliminar')
            ->getQuery()
            ->getResult()
            ;
    }
}

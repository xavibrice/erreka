<?php

namespace App\Repository;

use App\Entity\NoteCommercial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NoteCommercial|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteCommercial|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteCommercial[]    findAll()
 * @method NoteCommercial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteCommercialRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NoteCommercial::class);
    }

    public function findByDate($getUser)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.notice_date <= :date')
            ->andWhere('n.commercial = :agent')
            ->setParameter('date', new \DateTime())
            ->setParameter('agent',$getUser)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAgencyAndAgent($agency, $agent)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.commercial', 'a')
            ->andWhere('n.commercial = :agent')
            ->andWhere('a.agency = :agency')
            ->setParameter('agency', $agency)
            ->setParameter('agent', $agent)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAgency($agency)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.commercial', 'a')
            ->andWhere('a.agency = :agency')
            ->setParameter('agency', $agency)
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?NoteCommercial
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

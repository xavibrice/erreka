<?php

namespace App\Repository;

use App\Entity\NoteNew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NoteNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteNew[]    findAll()
 * @method NoteNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteNewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteNew::class);
    }

    // /**
    //  * @return NoteNew[] Returns an array of NoteNew objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NoteNew
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function alertsOnlyNoticesToDeveloper($getUser)
    {
        $datetime = new \DateTime();
        $date = $datetime->format('Y-m-d');

        return $this->createQueryBuilder('nn')
            ->innerJoin('nn.property', 'p')
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
}

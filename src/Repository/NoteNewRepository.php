<?php

namespace App\Repository;

use App\Entity\NoteNew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NoteNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteNew[]    findAll()
 * @method NoteNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteNewRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
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
}

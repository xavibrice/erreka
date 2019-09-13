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

    // /**
    //  * @return NoteCommercial[] Returns an array of NoteCommercial objects
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

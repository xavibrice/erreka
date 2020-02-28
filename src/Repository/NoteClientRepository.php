<?php

namespace App\Repository;

use App\Entity\NoteClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method NoteClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteClient[]    findAll()
 * @method NoteClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteClientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, NoteClient::class);
    }

    // /**
    //  * @return NoteClient[] Returns an array of NoteClient objects
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
    public function findOneBySomeField($value): ?NoteClient
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

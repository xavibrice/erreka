<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Client::class);
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @return Client[]
     */
    public function findFullName()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.full_name', 'ASC')
            ->getQuery()
            ->execute()
            ;
    }

    public function findFullNameMobile($data)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('(c.full_name LIKE :query OR c.mobile LIKE :phone)')
            ->setParameter('query', '%'.$data.'%')
            ->setParameter('phone', '%'.$data.'%')
            ->getQuery()
            ->execute()
            ;
    }


    /**
     * @param Client[]
     */
    public function findAllMatching(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('(c.full_name LIKE :query or c.mobile LIKE :mobile)')
            ->setParameter('query', '%'.$query.'%')
            ->setParameter('mobile', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}

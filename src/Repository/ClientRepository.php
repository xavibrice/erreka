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

    public function findAllMatching(string $query, int $limit = 5)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('(c.full_name LIKE :fullName OR c.mobile LIKE :mobile)')
            ->setParameter('fullName', '%'.$query.'%')
            ->setParameter('mobile', '%'.$query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
            ;
    }
}

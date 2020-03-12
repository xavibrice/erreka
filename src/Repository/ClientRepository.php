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

    public function findClienteForAgencyAndSell($agency)
    {
        return $this->createQueryBuilder('cli')
            ->innerJoin('cli.commercial', 'com')
            ->andWhere('com.agency = :agency')
            ->andWhere('cli.sellOrRent = :sell')
            ->setParameter('sell', true)
            ->setParameter('agency', $agency)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findClienteForAgencyAndRent($agency)
    {
        return $this->createQueryBuilder('cli')
            ->innerJoin('cli.commercial', 'com')
            ->andWhere('com.agency = :agency')
            ->andWhere('cli.sellOrRent = :sell')
            ->setParameter('sell', false)
            ->setParameter('agency', $agency)
            ->getQuery()
            ->getResult()
            ;
    }


    public function findFullName()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.full_name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findFullNameMobile($data)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.full_name LIKE :query')
            ->setParameter('query', '%'.$data.'%')
            ->getQuery()
            ->getResult()
            ;
//        return $this->createQueryBuilder('c')
//            ->andWhere('(c.full_name LIKE :query OR c.mobile LIKE :phone)')
//            ->setParameter('query', '%'.$data.'%')
//            ->setParameter('phone', '%'.$data.'%')
//            ->getQuery()
//            ->getResult()
//            ;
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

    public function alertsOnlyClientsSell($getUser)
    {
        $datetime = new \DateTime();
        $date = $datetime->format('Y-m-d');
        return $this->createQueryBuilder('c')
            ->andWhere('c.sellOrRent = :sell')
            ->andWhere('c.commercial = :agent')
            ->andWhere('c.nextCall <= :nextCalll')
            ->setParameter('sell', true)
            ->setParameter('agent', $getUser)
            ->setParameter('nextCalll', $date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function alertsOnlyClientsRent($getUser)
    {
        $datetime = new \DateTime();
        $date = $datetime->format('Y-m-d');
        return $this->createQueryBuilder('c')
            ->andWhere('c.sellOrRent = :sell')
            ->andWhere('c.commercial = :agent')
            ->andWhere('c.nextCall <= :nextCalll')
            ->setParameter('sell', false)
            ->setParameter('agent', $getUser)
            ->setParameter('nextCalll', $date)
            ->getQuery()
            ->getResult()
            ;
    }
}

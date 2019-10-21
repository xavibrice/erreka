<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }


    // /**
    //  * @return News[] Returns an array of News objects
    //  */

    public function findBySituation($situationSlug, $commercial)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.reason', 'r')
            ->innerJoin('r.situation', 's')
            ->andWhere('s.name_slug = :situation_slug')
            ->andWhere('n.state = :state')
            ->andWhere('n.commercial = :commercial')
            ->setParameter('situation_slug', $situationSlug)
            ->setParameter('state', true)
            ->setParameter('commercial', $commercial)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByRented()
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.reason', 'r')
            ->andWhere('r.name = :name')
            ->setParameter('name', 'Alquilado')
            ->getQuery()
            ->getResult()
            ;
    }

/*$news = $newsRepository->createQueryBuilder('n')
->innerJoin('n.reason', 'r')
->innerJoin('r.situation', 's')
->andWhere('s.name_slug = :situation_slug')
->andWhere('n.state = :state')
->andWhere('n.commercial = :commercial')
->setParameter('situation_slug', 'noticia')
->setParameter('state', true)
->setParameter('commercial', $this->getUser())
->getQuery()
->getResult();*/

    /*
    public function findOneBySomeField($value): ?News
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

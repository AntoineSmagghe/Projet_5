<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function takeAllExceptprivateEvent(){
        return $this->createQueryBuilder('a')
            ->andWhere('a.format != :val')
            ->andWhere('a.format != :val2')
            ->setParameter('val', 'private-event')
            ->setParameter('val2', 'members')
            ->orderBy('a.date_event', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findAllByformat($value)
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.format = :val')
            ->setParameter('val', $value)
            ->orderBy('article.date_event', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findAllDESC()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.format != :val')
            ->setParameter('val', 'members')
            ->orderBy('a.date_event', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
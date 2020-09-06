<?php

namespace App\Repository;

use App\Entity\BlogCommentResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogCommentResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogCommentResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogCommentResponse[]    findAll()
 * @method BlogCommentResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogCommentResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogCommentResponse::class);
    }

    // /**
    //  * @return BlogCommentResponse[] Returns an array of BlogCommentResponse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogCommentResponse
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

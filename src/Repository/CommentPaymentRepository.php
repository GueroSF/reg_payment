<?php

namespace App\Repository;

use App\Entity\CommentPayment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentPayment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentPayment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentPayment[]    findAll()
 * @method CommentPayment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentPaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentPayment::class);
    }

    // /**
    //  * @return CommentPayment[] Returns an array of CommentPayment objects
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
    public function findOneBySomeField($value): ?CommentPayment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

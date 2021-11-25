<?php

namespace App\Repository;

use App\Entity\ToastMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ToastMessage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ToastMessage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToastMessage[]    findAll()
 * @method ToastMessage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToastMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ToastMessage::class);
    }

    public function findAllUnread(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.readAt is NULL')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return ToastMessage[] Returns an array of ToastMessage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ToastMessage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\ProductOil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductOil|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductOil|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductOil[]    findAll()
 * @method ProductOil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductOilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductOil::class);
    }

    // /**
    //  * @return ProductOil[] Returns an array of ProductOil objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductOil
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

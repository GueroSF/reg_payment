<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param Account $account
     * @return Category[] | iterable
     */
    public function findByAccount(Account $account): iterable
    {
        return $this->createQueryBuilder('c')
            ->distinct()
            ->innerJoin(Posting::class, 'p')
            ->where('c.id = p.category')
            ->andWhere('p.account = :account')
            ->andWhere('p.deletedAt is NULL')
            ->setParameter('account', $account)
            ->getQuery()
            ->getResult();
    }

    public function findByAdditionalType(string $type): ?Category
    {
        return $this->createQueryBuilder('c')
            ->where('c.additionalType = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

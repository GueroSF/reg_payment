<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use App\Lib\PostingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Posting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Posting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Posting[]    findAll()
 * @method Posting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Posting::class);
    }

    /**
     * @param Account $account
     * @param Category $category
     * @return Posting[] | iterable
     */
    public function findByAccountAndCategory(Account $account, Category $category): iterable
    {
        return $this->createQueryBuilder('p')
            ->where('p.account = :account')
            ->andWhere('p.category = :category')
            ->setParameters([
                'account'  => $account,
                'category' => $category,
            ])
            ->orderBy('p.dateOperation', 'DESC')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function calcSumForAccount(Account $account): float
    {
        $received = $this->prepareReceived($account)->getSingleScalarResult();
        $spent = $this->prepareSpent($account)->getSingleScalarResult();

        return $received - $spent;
    }

    public function calcSumForCategory(Account $account, Category $category): float
    {
        $received = $this->prepareReceived($account, $category)->getSingleScalarResult();
        $spent = $this->prepareSpent($account, $category)->getSingleScalarResult();

        return $received - $spent;
    }

    private function prepareReceived(Account $account, ?Category $category = null): Query
    {
        return $this->prepareSqlForSum(PostingType::RECEIVED, $account, $category);
    }

    private function prepareSpent(Account $account, ?Category $category = null): Query
    {
        return $this->prepareSqlForSum(PostingType::SPENT, $account, $category);
    }

    private function prepareSqlForSum(int $type, Account $account, ?Category $category): Query
    {
        $sql = $this->createQueryBuilder('q')
            ->select('COALESCE(SUM(q.money),0)')
            ->where('q.type = :type')
            ->andWhere('q.account = :account')
            ->setParameters([
                'type'    => $type,
                'account' => $account,
            ]);

        if ($category !== null) {
            $sql
                ->andWhere('q.category = :category')
                ->setParameter('category', $category);
        }

        return $sql->getQuery();
    }
}

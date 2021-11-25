<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use App\Lib\PostingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

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

    public function removeByAccountAndCategory(Account $account, Category $category)
    {
        $postingList = $this->createQueryBuilder('p')
            ->select()
            ->where('p.account = :account')
            ->andWhere('p.category = :category')
            ->setParameters([
                'account'  => $account,
                'category' => $category,
            ])
            ->getQuery()
            ->getResult();

        foreach ($postingList as $posting) {
            $this->getEntityManager()->remove($posting);
        }

        $this->getEntityManager()->flush();

        return count($postingList);
    }

    /**
     * @param Account $account
     * @param Category $category
     * @param int|null $limit
     * @param int|null $offset
     * @return Posting[] | iterable
     */
    public function findByAccountAndCategory(Account $account, Category $category, ?int $limit, ?int $offset): iterable
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.account = :account')
            ->andWhere('p.category = :category')
            ->andWhere('p.deletedAt is NULL')
            ->setParameters([
                'account'  => $account,
                'category' => $category,
            ])
            ->orderBy('p.dateOperation', 'DESC')
            ->addOrderBy('p.id', 'DESC')
        ;

        if (null !== $limit && null !== $offset) {
            $qb
                ->setMaxResults($limit)
                ->setFirstResult($offset)
            ;
        }

        return $qb
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

    public function calcSumForAdditionalTypeInCategory(Category $category): float
    {
        $received = $this->prepareReceived(null, $category)->getSingleScalarResult();
        $spent = $this->prepareSpent(null, $category)->getSingleScalarResult();

        return $received - $spent;
    }

    private function prepareReceived(Account $account = null, Category $category = null): Query
    {
        return $this->prepareSqlForSum(PostingType::RECEIVED, $account, $category);
    }

    private function prepareSpent(Account $account = null, Category $category = null): Query
    {
        return $this->prepareSqlForSum(PostingType::SPENT, $account, $category);
    }

    private function prepareSqlForSum(int $type, ?Account $account, ?Category $category): Query
    {
        $sql = $this->createQueryBuilder('q')
            ->select('COALESCE(SUM(q.money),0)')
            ->where('q.type = :type')
            ->andWhere('q.deletedAt is NULL')
            ->setParameter('type', $type);

        if ($account !== null) {
            $sql
                ->andWhere('q.account = :account')
                ->setParameter('account', $account);
        }

        if ($category !== null) {
            $sql
                ->andWhere('q.category = :category')
                ->setParameter('category', $category);
        }

        return $sql->getQuery();
    }
}

<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Posting;
use App\Lib\CategoryAdditionalType;
use App\Lib\DTO\AccountDTO;
use App\Lib\DTO\CategoryDTO;
use App\Repository\PostingRepository;
use Doctrine\Persistence\ManagerRegistry;

class PreparePostingData
{
    private ManagerRegistry $mr;
    private PostingRepository $postingRepo;

    /**
     * PrepareTransactionData constructor.
     * @param ManagerRegistry $mr
     * @param PostingRepository $postingRepo
     */
    public function __construct(ManagerRegistry $mr, PostingRepository $postingRepo)
    {
        $this->mr = $mr;
        $this->postingRepo = $postingRepo;
    }

    /**
     * @return array | Posting[]
     */
    public function getLastOperations(int $limit = 5): array
    {
        return $this->postingRepo->findBy([], ['dateOperation' => 'DESC', 'id' => 'DESC'], $limit);
    }

    public function getCategory(Account $account, Category $category): CategoryDTO
    {
        return new CategoryDTO(
            $account->getId(),
            $category->getId(),
            $category->getName(),
            $this->postingRepo->calcSumForCategory($account, $category)
        );
    }

    /**
     * @return AccountDTO[] | iterable
     */
    public function getAllAccounts(): iterable
    {
        $accountRepo = $this->mr->getRepository(Account::class);

        foreach ($accountRepo->findAll() as $account) {
            yield $this->createAccountDTO($account);
        }
    }

    /**
     * @param Account $account
     * @return CategoryDTO[] | iterable
     */
    public function getAllCategoriesForAccount(Account $account): iterable
    {
        $categories = $this->getCategories($account);

        foreach ($categories as $category) {
            yield $this->getCategory($account, $category);
        }
    }

    public function removePostingFor(Account $account, Category $category): int
    {
        if ($this->postingRepo->calcSumForCategory($account, $category) !== 0.0) {
            throw new \RangeException('Sum in category is not zero');
        }

        return $this->postingRepo->removeByAccountAndCategory($account, $category);
    }

    public function getSumOnCreditCategory(): float
    {
        $creditCategory = $this->mr
            ->getRepository(Category::class)
            ->findByAdditionalType(CategoryAdditionalType::CREDIT);

        if ($creditCategory === null) {
            return 0;
        }

        $sum = $this->postingRepo->calcSumForAdditionalTypeInCategory($creditCategory);

        return abs($sum);
    }

    public function createAccountDTO(Account $account): AccountDTO
    {
        return new AccountDTO(
            $account->getId(),
            $account->getName(),
            $this->postingRepo->calcSumForAccount($account)
        );
    }

    private function getCategories(Account $account): iterable
    {
        $categoryRepo = $this->mr->getRepository(Category::class);

        return $categoryRepo->findByAccount($account);
    }
}

<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\Account;
use App\Entity\Category;
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
            yield new AccountDTO(
                $account->getId(),
                $account->getName(),
                $this->postingRepo->calcSumForAccount($account)
            );
        }
    }

    /**
     * @param Account $account
     * @return CategoryDTO[] | iterable
     */
    public function getAllCategoriesForAccount(Account $account): iterable
    {
        $categoryRepo = $this->mr->getRepository(Category::class);

        $categories = $categoryRepo->findByAccount($account);

        foreach ($categories as $category) {
            yield $this->getCategory($account, $category);
        }
    }
}

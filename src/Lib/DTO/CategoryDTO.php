<?php
declare(strict_types=1);

namespace App\Lib\DTO;


class CategoryDTO extends AbstractDTO
{
    private int $accountId;

    public function __construct(int $accountId, int $id, string $name, float $sum)
    {
        parent::__construct($id, $name, $sum);

        $this->accountId = $accountId;
    }

    /**
     * @return int
     */
    public function getAccountId(): int
    {
        return $this->accountId;
    }
}

<?php
declare(strict_types=1);

namespace App\Lib\DTO;


abstract class AbstractDTO
{
    protected int $id;

    protected string $name;

    protected float $sum;

    public function __construct(int $id, string $name, float $sum)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sum = $sum;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }
}

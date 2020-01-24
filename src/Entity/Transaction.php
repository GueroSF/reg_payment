<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuhTransaction
 *
 * @ORM\Table(name="buh_transaction", indexes={@ORM\Index(name="category", columns={"category"}), @ORM\Index(name="account", columns={"account"}), @ORM\Index(name="operations", columns={"operations"})})
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private float $money;

    /**
     * @ORM\Column(name="date_operations", type="date", nullable=false)
     */
    private \DateTimeInterface $dateOperations;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="account", referencedColumnName="id")
     * })
     */
    private Account $account;

    /**
     * @ORM\ManyToOne(targetEntity="Operation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operations", referencedColumnName="id")
     * })
     */
    private Operation $operations;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category", referencedColumnName="id")
     * })
     */
    private Category $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoney(): ?string
    {
        return $this->money;
    }

    public function setMoney(string $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getDateOperations(): ?\DateTimeInterface
    {
        return $this->dateOperations;
    }

    public function setDateOperations(\DateTimeInterface $dateOperations): self
    {
        $this->dateOperations = $dateOperations;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getOperations(): ?Operation
    {
        return $this->operations;
    }

    public function setOperations(?Operation $operations): self
    {
        $this->operations = $operations;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


}

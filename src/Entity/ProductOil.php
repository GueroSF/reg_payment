<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuhProductOil
 *
 * @ORM\Table(name="buh_product_oil")
 * @ORM\Entity(repositoryClass="App\Repository\ProductOilRepository")
 */
class ProductOil
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=7, nullable=false)
     */
    private string $month;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private float $payment;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private string $comment;

    /**
     * @ORM\Column(name="date_payment", type="date", nullable=false)
     */
    private \DateTimeInterface $datePayment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonth(): ?string
    {
        return $this->month;
    }

    public function setMonth(string $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function setPayment(string $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDatePayment(): ?\DateTimeInterface
    {
        return $this->datePayment;
    }

    public function setDatePayment(\DateTimeInterface $datePayment): self
    {
        $this->datePayment = $datePayment;

        return $this;
    }


}

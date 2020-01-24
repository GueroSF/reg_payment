<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuhCommentPayment
 *
 * @ORM\Table(name="buh_comment_payment", indexes={@ORM\Index(name="transaction_id", columns={"transaction_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CommentPaymentRepository")
 */
class CommentPayment
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private string $comment;

    /**
     * @var Transaction
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Transaction")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="transaction_id", referencedColumnName="id")
     * })
     */
    private Transaction $transaction;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }


}

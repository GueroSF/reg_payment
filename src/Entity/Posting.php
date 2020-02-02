<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="posting")
 * @ORM\Entity(repositoryClass="App\Repository\PostingRepository")
 * @Gedmo\SoftDeleteable(fieldName="deleteAt", timeAware=true)
 */
class Posting extends AbstractBaseEntity
{

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=false)
     */
    private ?float $money = null;

    /**
     * @ORM\Column(name="date_operation", type="date", nullable=false)
     */
    private ?\DateTimeInterface $dateOperation = null;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Account $account = null;

    /**
     * @ORM\Column(type="integer", nullable=false, length=1)
     */
    private ?int $type = null;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Category $category = null;

    /**
     * @ORM\OneToOne(targetEntity="Comment", mappedBy="posting", cascade={"all"})
     */
    private ?Comment $comment = null;

    /**
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private ?\DateTimeInterface $deletedAt = null;

    public function getMoney(): ?float
    {
        return $this->money;
    }

    public function setMoney(float $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->dateOperation;
    }

    public function setDateOperation(\DateTimeInterface $dateOperation): self
    {
        $this->dateOperation = $dateOperation;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getComment(): ?Comment
    {
        return $this->comment;
    }

    public function setComment(?Comment $comment): self
    {
        $this->comment = $comment;

        // set (or unset) the owning side of the relation if necessary
        $newTransaction = null === $comment ? null : $this;
        if ($comment->getPosting() !== $newTransaction) {
            $comment->setPosting($newTransaction);
        }

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }


}

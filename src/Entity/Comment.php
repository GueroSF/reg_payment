<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuhCommentPayment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment extends AbstractBaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $comment;

    /**
     * @ORM\OneToOne(targetEntity="Posting", inversedBy="comment")
     */
    private Posting $posting;

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPosting(): ?Posting
    {
        return $this->posting;
    }

    public function setPosting(?Posting $posting): self
    {
        $this->posting = $posting;

        return $this;
    }
}

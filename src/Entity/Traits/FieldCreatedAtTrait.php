<?php
declare(strict_types=1);

namespace App\Entity\Traits;


trait FieldCreatedAtTrait
{

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private \DateTimeInterface $createdAt;

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}

<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuhCategory
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category extends AbstractBaseEntity
{
    /**
     * @ORM\Column(name="name", type="string", length=25, nullable=false)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(name="additional_type", type="string", nullable=true, length=25)
     */
    private ?string $additionalType = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdditionalType(): ?string
    {
        return $this->additionalType;
    }

    public function setAdditionalType(?string $additionalType): self
    {
        $this->additionalType = $additionalType;

        return $this;
    }
}

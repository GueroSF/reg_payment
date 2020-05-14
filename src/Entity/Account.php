<?php
declare(strict_types=1);


namespace App\Entity;

use App\Entity\Traits\FieldCreatedAtTrait;
use App\Lib\Interfaces\DictionaryInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * BuhAccount
 *
 * @ORM\Table(name="account")
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account extends AbstractBaseEntity implements DictionaryInterface
{
    /**
     * @ORM\Column(name="name", type="string", length=25, nullable=false)
     */
    private string $name;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


}

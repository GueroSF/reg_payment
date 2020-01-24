<?php
declare(strict_types=1);


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuhAccount
 *
 * @ORM\Table(name="buh_account")
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private int $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=25, nullable=false)
     */
    private string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

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

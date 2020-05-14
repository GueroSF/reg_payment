<?php
declare(strict_types=1);

namespace App\Lib\Interfaces;


interface DictionaryInterface
{
    public function getId(): int;
    public function getName(): ?string;
}

<?php
declare(strict_types=1);

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FiltersExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('app_money', [$this, 'moneyFormat'])
        ];
    }

    public function moneyFormat(float $money): string
    {
        return number_format($money, 2, '.', ',');
    }
}

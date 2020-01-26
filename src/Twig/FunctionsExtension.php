<?php
declare(strict_types=1);

namespace App\Twig;


use App\Entity\Posting;
use App\Lib\PostingType;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FunctionsExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('posting_type', [$this, 'formatterPostingType']),
        ];
    }

    public function formatterPostingType(Posting $posting): string
    {
        return PostingType::typeAsText($posting->getType());
    }

}

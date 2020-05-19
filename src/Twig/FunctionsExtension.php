<?php
declare(strict_types=1);

namespace App\Twig;


use App\Entity\Posting;
use App\Entity\ToastMessage;
use App\Lib\PostingType;
use App\Service\ToastManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FunctionsExtension extends AbstractExtension
{
    private ToastManager $toast;

    public function __construct(ToastManager $toast)
    {
        $this->toast = $toast;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('posting_type', [$this, 'formatterPostingType']),
            new TwigFunction('toast_messages', [$this, 'toastMessages'])
        ];
    }

    public function formatterPostingType(Posting $posting): string
    {
        return PostingType::typeAsText($posting->getType());
    }

    /**
     * @return ToastMessage[]
     */
    public function toastMessages(): array
    {
        return $this->toast->getAllUnread();
    }
}

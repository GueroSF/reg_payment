<?php
declare(strict_types=1);

namespace App\Twig;


use App\Entity\Posting;
use App\Entity\ToastMessage;
use App\Lib\PostingType;
use App\Service\PreparePostingData;
use App\Service\ToastManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FunctionsExtension extends AbstractExtension
{
    private ToastManager $toast;
    private PreparePostingData $postingService;

    public function __construct(ToastManager $toast, PreparePostingData $postingData)
    {
        $this->toast = $toast;
        $this->postingService = $postingData;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('posting_type', [$this, 'formatterPostingType']),
            new TwigFunction('toast_messages', [$this, 'toastMessages']),
            new TwigFunction('last_operation', [$this, 'lastPostingOperation']),
        ];
    }

    /**
     * @return array | Posting[]
     */
    public function lastPostingOperation(): array
    {
        return $this->postingService->getLastOperations();
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

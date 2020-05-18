<?php
declare(strict_types=1);

namespace App\Service;


use App\Entity\ToastMessage;
use App\Lib\ToastMessageType;
use App\Repository\ToastMessageRepository;
use Doctrine\Persistence\ManagerRegistry;

class ToastManager
{
    private ManagerRegistry $mr;

    /**
     * @required
     */
    public function setManagerRegistry(ManagerRegistry $managerRegistry): void
    {
        $this->mr = $managerRegistry;
    }

    public function createSuccess(string $title, ?string $text): void
    {
        $this->create($title, $text, ToastMessageType::SUCCESS);
    }

    public function create(string $title, ?string $text, int $type): void
    {
        $toast = new ToastMessage();
        $toast
            ->setType($type)
            ->setTitle($title)
            ->setText($text);

        $manager = $this->mr->getManager();

        $manager->persist($toast);
        $manager->flush();
    }

    public function getAllUnread(): array
    {
        /** @var ToastMessageRepository $repo */
        $repo = $this->mr->getRepository(ToastMessage::class);

        return $repo->findAllUnread();
    }
}

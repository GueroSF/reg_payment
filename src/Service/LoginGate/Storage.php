<?php
declare(strict_types=1);

namespace App\Service\LoginGate;


use App\Entity\LoginGate\FailureLoginAttempt;
use App\Repository\LoginGate\FailureLoginAttemptRepository;
use Doctrine\ORM\EntityManagerInterface;

class Storage
{
    private FailureLoginAttemptRepository $repo;
    private EntityManagerInterface $em;

    public function __construct(FailureLoginAttemptRepository $repo, EntityManagerInterface $entityManager)
    {
        $this->repo = $repo;
        $this->em = $entityManager;
    }

    public function getCountAttemptsByIp(string $ip): int
    {
        $startWatchDate = $this->getStartWatchDate();

        return $this->repo->getCountAttemptsByIp($ip, $startWatchDate);
    }

    public function incrementCountAttempts(string $ip, string $username): void
    {
        $entity = new FailureLoginAttempt();
        $entity
            ->setIp($ip)
            ->setUsername($username);

        $this->em->persist($entity);
        $this->em->flush();
    }

    private function getStartWatchDate(): \DateTime
    {
        return new \DateTime('- 1 day');
    }
}

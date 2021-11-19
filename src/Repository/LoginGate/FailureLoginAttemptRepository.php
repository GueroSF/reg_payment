<?php

namespace App\Repository\LoginGate;

use App\Entity\LoginGate\FailureLoginAttempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FailureLoginAttempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method FailureLoginAttempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method FailureLoginAttempt[]    findAll()
 * @method FailureLoginAttempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FailureLoginAttemptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FailureLoginAttempt::class);
    }

    public function getCountAttemptsByIp(string $ip, \DateTime $startDate): int
    {
        return $this->createQueryBuilder('attempt')
            ->select('COUNT(attempt.id)')
            ->where('attempt.ip = :ip')
            ->andWhere('attempt.createdAt > :createdAt')
            ->setParameters([
                'ip'        => $ip,
                'createdAt' => $startDate
            ])
            ->getQuery()
            ->getSingleScalarResult();
    }
}

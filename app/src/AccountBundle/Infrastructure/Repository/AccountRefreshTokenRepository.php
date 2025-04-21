<?php

declare(strict_types=1);

namespace App\AccountBundle\Infrastructure\Repository;

use App\AccountBundle\Domain\Entity\AccountRefreshToken;
use App\AccountBundle\Domain\Repository\AccountRefreshTokenRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AccountRefreshTokenRepository implements AccountRefreshTokenRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    private EntityRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(AccountRefreshToken::class);
    }

    public function save(AccountRefreshToken $accountRefreshToken): void
    {
        $this->entityManager->persist($accountRefreshToken);
        $this->entityManager->flush();
    }

    public function delete(AccountRefreshToken $accountRefreshToken): void
    {
        $this->entityManager->remove($accountRefreshToken);
        $this->entityManager->flush();
    }
}

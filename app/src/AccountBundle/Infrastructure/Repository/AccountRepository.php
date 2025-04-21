<?php

declare(strict_types=1);

namespace App\AccountBundle\Infrastructure\Repository;

use App\AccountBundle\Domain\Entity\Account;
use App\AccountBundle\Domain\Exception\Account\AccountNotFoundException;
use App\AccountBundle\Domain\Repository\AccountRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

readonly class AccountRepository implements AccountRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    private EntityRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Account::class);
    }

    public function findByUsername(string $username): ?Account
    {
        return $this->repository->findOneBy(['username' => $username]);
    }

    public function findByUsernameExact(string $username): Account
    {
        return $this->repository->findOneBy(['username' => $username])
            ?? throw new AccountNotFoundException();
    }

    public function save(Account $account): void
    {
        $this->entityManager->persist($account);
        $this->entityManager->flush();
    }

    public function delete(Account $account): void
    {
        $this->entityManager->remove($account);
        $this->entityManager->flush();
    }
}

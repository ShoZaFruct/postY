<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Repository;

use App\AccountBundle\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function findByUsername(string $username): ?Account;

    public function findByUsernameExact(string $username): Account;

    public function save(Account $account): void;

    public function delete(Account $account): void;
}
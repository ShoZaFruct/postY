<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Repository;

use App\AccountBundle\Domain\Entity\AccountRefreshToken;

interface AccountRefreshTokenRepositoryInterface
{
    public function save(AccountRefreshToken $accountRefreshToken): void;

    public function delete(AccountRefreshToken $accountRefreshToken): void;
}

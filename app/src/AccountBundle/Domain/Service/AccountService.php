<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Service;

use App\AccountBundle\Domain\DTO\Request\CreateAccountRequest;
use App\AccountBundle\Domain\Entity\Account;
use App\AccountBundle\Domain\Exception\Account\AccountExistsException;
use App\AccountBundle\Domain\Repository\AccountRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class AccountService
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function createAccount(CreateAccountRequest $request): string
    {
        if (null !== $this->accountRepository->findByUsername(username: $request->username)) {
            throw new AccountExistsException();
        }

        $account = new Account(
            username: $request->username,
        );
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            user: $account,
            plainPassword: $request->password,
        );
        $account->setPassword($hashedPassword);

        $this->accountRepository->save(account: $account);

        return $account->getUsername();
    }
}
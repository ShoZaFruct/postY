<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Service;

use App\AccountBundle\Domain\DTO\Request\LoginAccountRequest;
use App\AccountBundle\Domain\Entity\Account;
use App\AccountBundle\Domain\Entity\AccountRefreshToken;
use App\AccountBundle\Domain\Exception\Account\AccountPasswordDoesNotMatchException;
use App\AccountBundle\Domain\Repository\AccountRefreshTokenRepositoryInterface;
use App\AccountBundle\Domain\Repository\AccountRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

readonly class AuthService
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private JWTTokenManagerInterface $jwtTokenManager,
        private AccountRefreshTokenRepositoryInterface $accountRefreshTokenRepository,
    ) {
    }

    /**
     * @param LoginAccountRequest $request
     * @return array<
     *     jwtToken: string,
     *     refreshToken: string,
     * >
     * @throws AccountPasswordDoesNotMatchException
     */
    public function loginAccount(LoginAccountRequest $request): array
    {
        $account = $this->accountRepository->findByUsernameExact(username: $request->username);
        if (false === password_verify(password: $request->password, hash: $account->getPassword())) {
            throw new AccountPasswordDoesNotMatchException();
        }

        $jwtToken = $this->jwtTokenManager->create(user: $account);
        $refreshToken = $this->generateRefreshToken(account: $account);

        return [
            'jwtToken' => $jwtToken,
            'refreshToken' => $refreshToken,
        ];
    }

    /**
     * @param Account $account
     * @return string
     */
    private function generateRefreshToken(Account $account): string
    {
        $token = \bin2hex(\random_bytes(32));
        $expiresAt = new \DateTimeImmutable('+30 day');

        $accountRefreshToken = new AccountRefreshToken(
            account: $account,
            refreshToken: $token,
            expiresAt: $expiresAt,
        );
        $this->accountRefreshTokenRepository->save($accountRefreshToken);

        return $token;
    }
}
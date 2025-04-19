<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\DTO\Request\CreateUserRequest;
use App\Domain\Entity\User;
use App\Domain\Exception\UserExistsException;
use App\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function createUser(CreateUserRequest $request): string
    {
        if (null !== $this->userRepository->findByUsername(username: $request->username)) {
            throw new UserExistsException();
        }

        $user = new User();
        $user->setUsername($request->username);
        $hashedPassword = $this->userPasswordHasher->hashPassword(
            user: $user,
            plainPassword: $request->password
        );
        $user->setPassword($hashedPassword);
        $this->userRepository->save(user: $user);

        return $user->getUsername();
    }
}
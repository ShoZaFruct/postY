<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\Repository;

use App\AccountBundle\Domain\Entity\Account;
use App\PostBundle\Domain\Entity\Post;

interface PostRepositoryInterface
{
    public function findByUuidAndAccountExact(string $uuid, Account $account): ?Post;

    public function findByUuid(string $uuid): ?Post;

    public function findByAccount(Account $account): array;

    public function findByFilter(array $filter, array $pagination = []): array;

    public function countByFilter(array $filter): int;

    public function save(Post $post): void;

    public function update(Post $post): Post;

    public function delete(Post $post): void;
}
<?php

declare(strict_types=1);

namespace App\PostBundle\Infrastructure\Repository;

use App\AccountBundle\Domain\Entity\Account;
use App\PostBundle\Domain\Entity\Post;
use App\PostBundle\Domain\Exception\PostNotFoundException;
use App\PostBundle\Domain\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

readonly class PostRepository implements PostRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    private EntityRepository $repository;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Post::class);
    }

    public function findByUuidAndAccountExact(string $uuid, Account $account): ?Post
    {
        $result = $this->repository->createQueryBuilder('post')
            ->where('post.uuid = :uuid')
            ->andWhere('post.account = :account')
            ->setParameter('uuid', $uuid)
            ->setParameter('account', $account)
            ->getQuery()->getResult();

        return false === empty($result) ? current($result)
            : throw new PostNotFoundException();
    }

    public function findByUuid(string $uuid): ?Post
    {
        return $this->repository->findOneBy(['uuid' => $uuid]);
    }

    public function findByAccount(Account $account): array
    {
        return $this->repository->createQueryBuilder('post')
            ->where('post.account = :account')
            ->setParameter('account', $account)
            ->getQuery()->getResult();
    }

    public function save(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function update(Post $post): Post
    {
        $this->entityManager->flush();

        return $post;
    }

    public function delete(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
<?php

declare(strict_types=1);

namespace App\PostBundle\Infrastructure\Repository;

use App\AccountBundle\Domain\Entity\Account;
use App\PostBundle\Domain\Entity\Post;
use App\PostBundle\Domain\Exception\PostNotFoundException;
use App\PostBundle\Domain\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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

    public function findByFilter(array $filter, array $pagination = []): array
    {
        $query = $this->createFilter($filter);
        $query = $this->createPaginator($query, $pagination);

        return $query->getQuery()->getResult();
    }

    public function countByFilter(array $filter): int
    {
        $query = $this->createFilter($filter);

        return count($query->getQuery()->getResult());
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

    private function createFilter(array $filter): QueryBuilder
    {
        $query = $this->repository->createQueryBuilder('post');

        if (null !== $filter['username']) {
            $query->leftJoin('post.account', 'account')
                ->andWhere('account.username = :username')
                ->setParameter('username', $filter['username']);
        }

        if (null !== $filter['createdAt']) {
            try {
                $date = new \DateTime($filter['createdAt']);
                $query->andWhere('post.createdAt BETWEEN :startOfDay AND :endOfDay')
                    ->setParameter('startOfDay', $date->format('Y-m-d 00:00:00'))
                    ->setParameter('endOfDay', $date->format('Y-m-d 23:59:59'));
            } catch (\Exception $exception) {
                throw new PostNotFoundException($exception->getMessage());
            }
        }

        return $query;
    }

    private function createPaginator(QueryBuilder $query, array $pagination): QueryBuilder
    {
        if (null !== $pagination['page']
            && null !== $pagination['limit']
        ) {
            $query->setFirstResult(($pagination['page'] - 1) * $pagination['limit'])
                ->setMaxResults($pagination['limit']);
        }

        return $query;
    }
}
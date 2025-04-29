<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\GetPostByFilter;

use App\PostBundle\Domain\DTO\Response\GetPostByFilterResponse;
use App\PostBundle\Domain\Repository\PostRepositoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class GetPostByFilterHandler
{
    public function __construct(
        private ValidatorInterface $validator,
        private PostRepositoryInterface $postRepository,
    ) {
    }

    public function __invoke(GetPostByFilterCommand $command): GetPostByFilterResponse
    {
        $this->validator->validate($command);

        $filter = [
            'username' => $command->username ?? null,
            'createdAt' => $command->createdAt ?? null,
        ];

        $pagination = [
            'page' => $command->page ?? 1,
            'limit' => $command->limit ?? 10,
        ];

        $posts = $this->postRepository->findByFilter(filter: $filter, pagination: $pagination);
        $totalItems = $this->postRepository->countByFilter(filter: $filter);
        $totalPages = ceil($totalItems / $pagination['limit']);

        return new GetPostByFilterResponse(
            items: $posts,
            pagination: [
                'currentPage' => $pagination['page'],
                'totalItems' => $totalItems,
                'totalPages' => $totalPages,
            ],
        );
    }
}
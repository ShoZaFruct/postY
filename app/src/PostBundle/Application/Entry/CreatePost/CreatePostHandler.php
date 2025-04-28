<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\CreatePost;

use App\PostBundle\Application\DTO\Response\CreatePostResponse;
use App\PostBundle\Domain\DTO\Request\CreatePostRequest;
use App\PostBundle\Domain\Service\PostService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreatePostHandler
{
    public function __construct(
        private ValidatorInterface $validator,
        private PostService $postService,
    ) {
    }

    public function __invoke(CreatePostCommand $command): CreatePostResponse
    {
        $this->validator->validate($command);

        $response = $this->postService->create(new CreatePostRequest(
            account: $command->account,
            title: $command->title,
            content: $command->content,
        ));

        return new CreatePostResponse(
            uuid: $response->getUuid(),
            title: $response->getTitle(),
            content: $response->getContent(),
            createdAt: $response->getCreatedAt(),
        );
    }
}
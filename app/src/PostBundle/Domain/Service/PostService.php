<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\Service;

use App\PostBundle\Domain\DTO\Request\CreatePostRequest;
use App\PostBundle\Domain\DTO\Request\DeletePostByUuidAndAccountRequest;
use App\PostBundle\Domain\DTO\Request\UpdatePostByUuidAndAccountRequest;
use App\PostBundle\Domain\DTO\Response\CreatePostResponse;
use App\PostBundle\Domain\DTO\Response\UpdatePostByUuidAndAccountResponse;
use App\PostBundle\Domain\Entity\Post;
use App\PostBundle\Domain\Exception\CreatePostException;
use App\PostBundle\Domain\Exception\DeletePostException;
use App\PostBundle\Domain\Repository\PostRepositoryInterface;

readonly class PostService
{
    public function __construct(
        private PostRepositoryInterface $postRepository,
    ) {
    }

    public function create(CreatePostRequest $request): CreatePostResponse
    {
        $post = new Post(
            account: $request->getAccount(),
            title: $request->getTitle(),
            content: $request->getContent(),
        );

        try {
            $this->postRepository->save($post);
        }  catch (\Exception $exception) {
            throw new CreatePostException($exception->getMessage(), $exception->getCode());
        }

        return new CreatePostResponse(
            $post->getUuid(),
            $post->getTitle(),
            $post->getContent(),
            $post->getCreatedAt(),
        );
    }

    public function updateByUuidAndAccount(UpdatePostByUuidAndAccountRequest $request): UpdatePostByUuidAndAccountResponse
    {
        $post = $this->postRepository->findByUuidAndAccountExact(
            uuid: $request->getUuid(),
            account: $request->getAccount()
        );

        if (null !== $request->getTitle()) {
            $post->setTitle($request->getTitle());
        }
        if (null !== $request->getContent()) {
            $post->setContent($request->getContent());
        }

        $post = $this->postRepository->update($post);

        return new UpdatePostByUuidAndAccountResponse(
            uuid: $post->getUuid(),
            title: $post->getTitle(),
            content: $post->getContent(),
            createdAt: $post->getCreatedAt(),
            updatedAt: $post->getUpdatedAt(),
        );
    }

    public function deleteByUuidAndAccount(DeletePostByUuidAndAccountRequest $request): void
    {
        $post = $this->postRepository->findByUuidAndAccountExact(
            uuid: $request->getUuid(),
            account: $request->getAccount()
        );

        try{
            $this->postRepository->delete($post);
        } catch (\Exception $exception) {
            throw new DeletePostException($exception->getMessage(), $exception->getCode());
        }
    }
}

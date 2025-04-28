<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\UpdatePostByUuidAndAccount;

use App\PostBundle\Application\DTO\Response\UpdatePostByUuidAndAccountResponse;
use App\PostBundle\Domain\DTO\Request\UpdatePostByUuidAndAccountRequest;
use App\PostBundle\Domain\Service\PostService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UpdatePostByUuidAndAccountHandler
{
    public function __construct(
        private ValidatorInterface $validator,
        private PostService $postService,
    ) {
    }

    public function __invoke(UpdatePostByUuidAndAccountCommand $command): UpdatePostByUuidAndAccountResponse
    {
        $this->validator->validate($command);

        $response = $this->postService->updateByUuidAndAccount(new UpdatePostByUuidAndAccountRequest(
            account: $command->account,
            uuid: $command->uuid,
            title: $command->title,
            content: $command->content,
        ));

        return new UpdatePostByUuidAndAccountResponse(
            uuid: $response->getUuid(),
            title: $response->getTitle(),
            content: $response->getContent(),
            createdAt: $response->getCreatedAt(),
            updatedAt: $response->getUpdatedAt(),
        );
    }
}
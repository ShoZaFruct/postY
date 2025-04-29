<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Entry\DeletePostByUuidAndAccount;

use App\PostBundle\Domain\DTO\Request\DeletePostByUuidAndAccountRequest;
use App\PostBundle\Domain\Service\PostService;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class DeletePostByUuidAndAccountHandler
{
    public function __construct(
        private ValidatorInterface $validator,
        private PostService $postService,
    ) {
    }

    public function __invoke(DeletePostByUuidAndAccountCommand $command): void
    {
        $this->validator->validate($command);

        $this->postService->deleteByUuidAndAccount(new DeletePostByUuidAndAccountRequest(
            account: $command->account,
            uuid: $command->uuid,
        ));
    }
}
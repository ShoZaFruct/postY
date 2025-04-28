<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Controller;

use App\AccountBundle\Domain\Entity\Account;
use App\PostBundle\Application\DTO\Response\CreatePostResponse;
use App\PostBundle\Application\DTO\Response\UpdatePostByUuidAndAccountResponse;
use App\PostBundle\Application\Entry\CreatePost\CreatePostCommand;
use App\PostBundle\Application\Entry\CreatePost\CreatePostHandler;
use App\PostBundle\Application\Entry\UpdatePostByUuidAndAccount\UpdatePostByUuidAndAccountCommand;
use App\PostBundle\Application\Entry\UpdatePostByUuidAndAccount\UpdatePostByUuidAndAccountHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Security(name: CurrentUser::class)]
    #[OA\Post(
        path: '/api/v1/post/create',
        description: 'Создание поста',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: CreatePostCommand::class, groups: ['default']),
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Пост создан',
                content: new OA\JsonContent(
                    ref: new Model(type: CreatePostResponse::class, groups: ['default']),
                )
            ),
        ],
    )]
    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(
        #[CurrentUser] Account $account,
        Request $request,
        CreatePostHandler $createPostHandler,
    ): JsonResponse {
        $requestData = json_decode($request->getContent(), true);

        return $this->json(
            ($createPostHandler)(new CreatePostCommand(
                account: $account,
                title: $requestData['title'],
                content: $requestData['content'],
            )),
        );
    }

    #[IsGranted('ROLE_USER')]
    #[Security(name: CurrentUser::class)]
    #[OA\Post(
        path: '/api/v1/post/update',
        description: 'Обновление поста',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: UpdatePostByUuidAndAccountCommand::class, groups: ['default']),
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Пост обновлен',
                content: new OA\JsonContent(
                    ref: new Model(type: UpdatePostByUuidAndAccountResponse::class, groups: ['default']),
                )
            ),
        ]
    )]
    #[Route('/update', name: 'update', methods: ['POST'])]
    public function update(
        #[CurrentUser] Account $account,
        Request $request,
        UpdatePostByUuidAndAccountHandler $updatePostByUuidHandler,
    ): JsonResponse {
        $requestData = json_decode($request->getContent(), true);

        return $this->json(
            ($updatePostByUuidHandler)(new UpdatePostByUuidAndAccountCommand(
                account: $account,
                uuid: $requestData['uuid'],
                title: $requestData['title'] ?? null,
                content: $requestData['content'] ?? null,
            )),
        );
    }
}

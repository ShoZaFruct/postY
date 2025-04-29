<?php

declare(strict_types=1);

namespace App\PostBundle\Application\Controller;

use App\AccountBundle\Domain\Entity\Account;
use App\PostBundle\Application\DTO\Response\CreatePostResponse;
use App\PostBundle\Application\DTO\Response\UpdatePostByUuidAndAccountResponse;
use App\PostBundle\Application\Entry\CreatePost\CreatePostCommand;
use App\PostBundle\Application\Entry\CreatePost\CreatePostHandler;
use App\PostBundle\Application\Entry\DeletePostByUuidAndAccount\DeletePostByUuidAndAccountCommand;
use App\PostBundle\Application\Entry\DeletePostByUuidAndAccount\DeletePostByUuidAndAccountHandler;
use App\PostBundle\Application\Entry\GetPostByFilter\GetPostByFilterCommand;
use App\PostBundle\Application\Entry\GetPostByFilter\GetPostByFilterHandler;
use App\PostBundle\Application\Entry\UpdatePostByUuidAndAccount\UpdatePostByUuidAndAccountCommand;
use App\PostBundle\Application\Entry\UpdatePostByUuidAndAccount\UpdatePostByUuidAndAccountHandler;
use App\PostBundle\Domain\DTO\Response\GetPostByFilterResponse;
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
            new OA\Response(
                response: 500,
                description: 'Ошибка',
                content: new OA\JsonContent(
                    type: 'string',
                    example: 'Текст ошибки',
                ),
            )
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
            new OA\Response(
                response: 500,
                description: 'Ошибка',
                content: new OA\JsonContent(
                    type: 'string',
                    example: 'Текст ошибки',
                ),
            )
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

    #[IsGranted('ROLE_USER')]
    #[Security(name: CurrentUser::class)]
    #[OA\Post(
        path: '/api/v1/post/delete',
        description: 'Удаление поста',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: DeletePostByUuidAndAccountCommand::class, groups: ['default']),
            )
        ),
        responses: [
            new OA\Response(
                response: 204,
                description: 'Пост удален',
            ),
            new OA\Response(
                response: 500,
                description: 'Ошибка',
                content: new OA\JsonContent(
                    type: 'string',
                    example: 'Текст ошибки',
                ),
            )
        ]
    )]
    #[Route('/delete', name: 'delete', methods: ['POST'])]
    public function delete(
        #[CurrentUser] Account $account,
        Request $request,
        DeletePostByUuidAndAccountHandler $deletePostByUuidHandler,
    ): JsonResponse {
        $requestData = json_decode($request->getContent(), true);

        ($deletePostByUuidHandler)(new DeletePostByUuidAndAccountCommand(
            account: $account,
            uuid: $requestData['uuid'],
        ));

        return $this->json(data: [], status: 204);
    }

    #[IsGranted('ROLE_USER')]
    #[Security(name: CurrentUser::class)]
    #[OA\Get(
        path: '/api/v1/post/list',
        description: 'Список постов',
        parameters: [
            new OA\Parameter(
                name: 'username',
                description: 'Имя пользователя для фильтрации постов',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', nullable: true)
            ),
            new OA\Parameter(
                name: 'createdAt',
                description: 'Дата создания поста (формат: Y-m-d)',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string', format: 'string', nullable: true)
            ),
            new OA\Parameter(
                name: 'page',
                description: 'Номер страницы',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer', nullable: true)
            ),
            new OA\Parameter(
                name: 'limit',
                description: 'Лимит элементов на странице',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer', nullable: true)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Список постов',
                content: new OA\JsonContent(
                    ref: new Model(type: GetPostByFilterResponse::class, groups: ['default']),
                )
            ),
            new OA\Response(
                response: 500,
                description: 'Ошибка',
                content: new OA\JsonContent(
                    type: 'string',
                    example: 'Текст ошибки',
                ),
            )
        ]
    )]
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function list(
        #[CurrentUser] Account $account,
        Request $request,
        GetPostByFilterHandler $getPostFilterHandler,
    ): JsonResponse
    {
        return $this->json(
            ($getPostFilterHandler)(new GetPostByFilterCommand(
                username: true === empty($request->query->get('username')) ? null
                    : $request->query->get('username'),
                createdAt: true === empty($request->query->get('createdAt')) ? null
                    : $request->query->get('createdAt'),
                page: true === empty($request->query->get('page')) ? null
                    : $request->query->getInt('page'),
                limit: true === empty($request->query->get('limit')) ? null
                    : $request->query->getInt('limit'),
            )),
        );
    }
}

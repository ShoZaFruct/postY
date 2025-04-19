<?php

declare(strict_types=1);

namespace App\Application\Controller;

use App\Application\Entry\CreateUser\CreateUserCommand;
use App\Application\Entry\CreateUser\CreateUserHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/user', name: 'user_')]
class UserController extends AbstractController
{

    #[OA\Post(
        path: '/user/create',
        description: 'Создание пользователя',
        requestBody: new OA\RequestBody(
            ref: new Model(type: CreateUserCommand::class, groups: ['default']),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Пользователь создан',
                content: new OA\JsonContent(
                    description: 'Имя пользователя',
                    type: 'string',
                ),
            ),
            new OA\Response(
                response: 422,
                description: 'Ошибка: пользователь существует',
                content: new OA\JsonContent(
                    type: 'string',
                    example: 'User already exists.',
                ),
            )
        ]
    )]
    #[Route(path: '/create', name: 'create', methods: ['POST'])]
    public function createUser(
        Request $request,
        CreateUserHandler $createUserHandler,
    ): JsonResponse {
        return $this->json(
            ($createUserHandler)(
                new CreateUserCommand(
                    username: $request->get('username'),
                    password: $request->get('password'),
                )
            )
        );
    }
}
<?php

declare(strict_types=1);

namespace App\AccountBundle\Application\Controller;

use App\AccountBundle\Application\Entry\CreateAccount\CreateAccountCommand;
use App\AccountBundle\Application\Entry\CreateAccount\CreateAccountHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface $logger,
    ) {
    }

    #[OA\Post(
        path: '/api/v1/account/create',
        description: 'Создание аккаунта',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: CreateAccountCommand::class, groups: ['default']),
            )
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
                    example: 'Account already exists.',
                ),
            )
        ]
    )]
    #[Route(path: '/create', name: 'create', methods: ['POST'])]
    public function createUser(
        Request $request,
        CreateAccountHandler $createAccountHandler,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $this->logger->debug('account_create_post_data', [
            'username' => $data['username'],
            'password' => $data['password'],
        ]);

        return $this->json(
            ($createAccountHandler)(
                new CreateAccountCommand(
                    username: $data['username'],
                    password: $data['password'],
                )
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace App\AccountBundle\Application\Controller;

use App\AccountBundle\Application\Entry\LoginAccount\LoginAccountCommand;
use App\AccountBundle\Application\Entry\LoginAccount\LoginAccountHandler;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[OA\Post(
        path: '/api/v1/account/login',
        description: 'Авторизация аккаутна',
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                ref: new Model(type: LoginAccountCommand::class, groups: ['default']),
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Данные jwt авторизации',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property('jwtToken', type: 'string'),
                        new OA\Property('refreshToken', type: 'string'),
                    ]
                ),

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
    #[Route(path: '/login', name: 'login', methods: ['POST'])]
    public function login(
        Request $request,
        LoginAccountHandler $loginAccountHandler,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        return $this->json(
            ($loginAccountHandler)(
                new LoginAccountCommand(
                    username: $data['username'],
                    password: $data['password'],
                )
            )
        );
    }
//
//    public function refreshToken(
//
//    ): JsonResponse
//    {
//        return $this->json(
//
//        );
//    }
}
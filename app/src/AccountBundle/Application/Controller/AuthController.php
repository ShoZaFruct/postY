<?php

declare(strict_types=1);

namespace App\AccountBundle\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends AbstractController
{
    public function login(
        Request $request,
    ): JsonResponse {
        return $this->json(

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
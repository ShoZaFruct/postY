<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\Exception;

class PostNotFoundException extends \Exception
{
    public function __construct(string $message = 'Post not found')
    {
        parent::__construct(message: $message, code: 404);
    }
}
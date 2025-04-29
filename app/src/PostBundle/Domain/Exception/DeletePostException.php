<?php

declare(strict_types=1);

namespace App\PostBundle\Domain\Exception;

class DeletePostException extends \Exception
{
    public function __construct(string $message, int $code = 500) {
        parent::__construct(message: $message, code: $code);
    }
}
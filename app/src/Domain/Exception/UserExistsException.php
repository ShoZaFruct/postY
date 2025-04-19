<?php

namespace App\Domain\Exception;

class UserExistsException extends \Exception
{
    public function __construct(
        string $message = 'User already exists.'
    ) {
        parent::__construct($message, 422);
    }
}
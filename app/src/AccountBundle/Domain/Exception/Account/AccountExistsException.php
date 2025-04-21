<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Exception\Account;

class AccountExistsException extends \Exception
{
    public function __construct(
        string $message = 'Account already exists.'
    ) {
        parent::__construct($message, 422);
    }
}
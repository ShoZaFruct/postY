<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Exception\Account;

class AccountNotFoundException extends \Exception
{
    public function __construct(
        string $message = 'Account not found.'
    ) {
        parent::__construct($message, 404);
    }
}

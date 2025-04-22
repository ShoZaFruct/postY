<?php

declare(strict_types=1);

namespace App\AccountBundle\Domain\Exception\Account;

class AccountPasswordDoesNotMatchException extends \Exception
{
    public function __construct(
        string $message = 'Account password does not match.',
    ) {
        parent::__construct($message, 401);
    }
}

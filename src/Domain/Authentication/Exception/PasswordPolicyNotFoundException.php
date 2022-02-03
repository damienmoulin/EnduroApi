<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Exception;

use RuntimeException;

class PasswordPolicyNotFoundException extends RuntimeException
{
    public function __construct(\Exception $previous = null)
    {
        parent::__construct('Password policy not found', 0, $previous);
    }
}

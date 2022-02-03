<?php

declare(strict_types=1);

namespace App\UseCase\Component;

use RuntimeException;

class UnauthorizedException extends RuntimeException
{
    private UnauthorizedError $error;

    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->error = new UnauthorizedError($message);
    }

    public function getError(): UnauthorizedError
    {
        return $this->error;
    }
}

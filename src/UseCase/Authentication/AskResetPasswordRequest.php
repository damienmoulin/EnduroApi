<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

/** @psalm-immutable */
class AskResetPasswordRequest
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}

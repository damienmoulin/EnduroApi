<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

/** @psalm-immutable */
class ResetPasswordRequest
{
    public string $confirmationToken;
    public string $firstPassword;
    public string $secondPassword;

    public function __construct(string $confirmationToken, string $firstPassword, string $secondPassword)
    {
        $this->confirmationToken = $confirmationToken;
        $this->firstPassword = $firstPassword;
        $this->secondPassword = $secondPassword;
    }
}

<?php

declare(strict_types=1);

namespace App\Presenter\Authentication;

use App\Infrastructure\Authentication\User;

/** @psalm-immutable */
class HtmlResetPasswordViewModel
{
    public ?User $userToLogIn;
    public string $error;

    public function __construct(?User $userToLogIn, string $error)
    {
        $this->userToLogIn = $userToLogIn;
        $this->error = $error;
    }
}

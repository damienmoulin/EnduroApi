<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

/** @psalm-immutable */
class ResetPasswordResponse
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

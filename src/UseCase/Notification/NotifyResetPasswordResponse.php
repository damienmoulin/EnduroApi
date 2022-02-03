<?php

declare(strict_types=1);

namespace App\UseCase\Notification;

/** @psalm-immutable */
class NotifyResetPasswordResponse
{
    public Email $email;

    public function __construct(Email $email)
    {
        $this->email = $email;
    }
}

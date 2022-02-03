<?php

declare(strict_types=1);

namespace App\UseCase\Notification;

/** @psalm-immutable */
class NotifyResetPasswordRequest
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}

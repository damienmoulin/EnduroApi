<?php

declare(strict_types=1);

namespace App\UseCase\Notification;

use App\UseCase\Component\UseCaseErrorResponse;

interface NotifyResetPasswordPresenter
{
    /**
     * @param UseCaseErrorResponse|NotifyResetPasswordResponse $response
     */
    public function present($response): void;
}

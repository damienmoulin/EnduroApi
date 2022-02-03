<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

use App\UseCase\Component\UseCaseErrorResponse;

interface AskResetPasswordPresenter
{
    /**
     * @param UseCaseErrorResponse|AskResetPasswordResponse $response
     */
    public function present($response): void;
}

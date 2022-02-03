<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

use App\UseCase\Component\UseCaseErrorResponse;

interface ResetPasswordPresenter
{
    /**
     * @param UseCaseErrorResponse|ResetPasswordResponse $response
     */
    public function present($response): void;
}

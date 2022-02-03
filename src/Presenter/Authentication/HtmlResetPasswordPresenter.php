<?php

declare(strict_types=1);

namespace App\Presenter\Authentication;

use App\Infrastructure\Authentication\User;
use App\UseCase\Authentication\ResetPasswordPresenter;
use App\UseCase\Authentication\ResetPasswordResponse;
use LogicException;

class HtmlResetPasswordPresenter implements ResetPasswordPresenter
{
    public ?HtmlResetPasswordViewModel $viewModel = null;

    public function present($response): void
    {
        if ($response instanceof ResetPasswordResponse) {
            $this->viewModel = new HtmlResetPasswordViewModel(User::createFromUserDTO($response->user), '');
        } else {
            $this->viewModel = new HtmlResetPasswordViewModel(null, $response->errors[0]->getMessage());
        }
    }

    public function getViewModel(): HtmlResetPasswordViewModel
    {
        if (null === $this->viewModel) {
            throw new LogicException('Trying to access viewModel before calling present method');
        }

        return $this->viewModel;
    }
}

<?php


namespace App\Presenter\Authentication;


use App\UseCase\Authentication\RegistrationPresenter;
use App\UseCase\Authentication\RegistrationResponse;

class HtmlRegistrationPresenter implements RegistrationPresenter
{
    public ?HtmlRegistrationViewModel $viewModel = null;

    public function present($response): void
    {
        if ($response instanceof RegistrationResponse) {
            $this->viewModel = new HtmlRegistrationViewModel($response->user, '');
        } else {
            $this->viewModel = new HtmlRegistrationViewModel(null, $response->errors[0]->getMessage());
        }
    }

    public function getViewModel(): HtmlRegistrationViewModel
    {
        if (null === $this->viewModel) {
            throw new \LogicException('Trying to access viewModel before calling present method');
        }

        return $this->viewModel;
    }
}

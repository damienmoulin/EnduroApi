<?php

declare(strict_types=1);

namespace App\Presenter\Authentication;

use App\UseCase\Authentication\AskResetPasswordPresenter;
use App\UseCase\Authentication\AskResetPasswordResponse;
use LogicException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class HtmlAskResetPasswordPresenter implements AskResetPasswordPresenter
{
    private TranslatorInterface $translator;
    private UrlGeneratorInterface $urlGenerator;
    public ?HtmlAskResetPasswordViewModel $viewModel = null;

    public function __construct(TranslatorInterface $translator, UrlGeneratorInterface $urlGenerator)
    {
        $this->translator = $translator;
        $this->urlGenerator = $urlGenerator;
    }

    public function present($response): void
    {
        if ($response instanceof AskResetPasswordResponse) {
            $this->viewModel = new HtmlAskResetPasswordViewModel(
                $this->translator->trans('ask-reset-password.success-message'),
                $this->urlGenerator->generate('app_login'),
                ''
            );
        } else {
            $this->viewModel = new HtmlAskResetPasswordViewModel('', '', $response->errors[0]->getMessage());
        }
    }

    public function getViewModel(): HtmlAskResetPasswordViewModel
    {
        if (null === $this->viewModel) {
            throw new LogicException('Trying to access viewModel before calling present method');
        }

        return $this->viewModel;
    }
}

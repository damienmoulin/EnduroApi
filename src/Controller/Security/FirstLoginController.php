<?php


namespace App\Controller\Security;


use App\Infrastructure\Authentication\AuthorizationCodeListener;
use App\Infrastructure\Authentication\LoginFormAuthenticator;
use App\Presenter\Authentication\HtmlResetPasswordPresenter;
use App\Presenter\Component\SideEventPresenter;
use App\UseCase\Authentication\ResetPasswordRequest;
use App\UseCase\Authentication\ResetPasswordUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use LogicException;

class FirstLoginController extends AbstractController
{
    private TranslatorInterface $translator;

    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator = $translator;
    }

    public function firstLogin(
        Request $request,
        LoginFormAuthenticator $authenticator,
        GuardAuthenticatorHandler $guardHandler,
        ResetPasswordUseCase $useCase,
        HtmlResetPasswordPresenter $presenter,
        SessionInterface $session,
        SideEventPresenter $sideEventPresenter
    ): ?Response {
        if ($this->getUser()) {
            throw new LogicException($this->translator->trans('exception.login.already_logged'));
        }
        $errorMessage = '';
        if ($request->isMethod('POST')) {
            $useCase->handle(
                new ResetPasswordRequest(
                    (string) $request->request->get('confirmation_token'),
                    (string) $request->request->get('first_password'),
                    (string) $request->request->get('second_password'),
                ),
                $presenter
            );
            $viewModel = $presenter->getViewModel();
            if (null !== $viewModel->userToLogIn) {
                return $guardHandler->authenticateUserAndHandleSuccess(
                    $viewModel->userToLogIn,
                    $request,
                    $authenticator,
                    AuthorizationCodeListener::FIREWALL_NAME
                );
            } else {
                $errorMessage = $viewModel->error;
            }
        } else {
            if ($redirectUri = $request->query->get('redirect_uri')) {
                $this->saveTargetPath($session, AuthorizationCodeListener::FIREWALL_NAME, $redirectUri);
            }
        }

        return $this->render('security/first-login.html.twig', [
            'confirmation_token' => $request->query->get('confirmation_token', ''),
            'errorMessage' => $errorMessage,
        ]);
    }
}

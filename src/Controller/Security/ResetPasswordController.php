<?php


namespace App\Controller\Security;


use App\Infrastructure\Authentication\AuthorizationCodeListener;
use App\Infrastructure\Authentication\LoginFormAuthenticator;
use App\Presenter\Authentication\HtmlResetPasswordPresenter;
use App\UseCase\Authentication\ResetPasswordRequest;
use App\UseCase\Authentication\ResetPasswordUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class ResetPasswordController extends AbstractController
{
    public function resetPassword(
        Request $request,
        LoginFormAuthenticator $authenticator,
        GuardAuthenticatorHandler $guardHandler,
        ResetPasswordUseCase $useCase,
        HtmlResetPasswordPresenter $presenter,
        string $passwordToken
    ): ?Response {
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
        }

        return $this->render('security/reset-password.html.twig', [
            'confirmation_token' => $passwordToken,
            'errorMessage' => $errorMessage,
        ]);
    }
}

<?php


namespace App\Controller\Security;

use App\Domain\Authentication\User;
use App\Form\Security\RegistrationType;
use App\Infrastructure\Authentication\AuthorizationCodeListener;
use App\Infrastructure\Authentication\LoginFormAuthenticator;
use App\Presenter\Authentication\HtmlRegistrationPresenter;
use App\UseCase\Authentication\RegistrationRequest;
use App\UseCase\Authentication\RegistrationUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class RegistrationController extends AbstractController
{
    private RegistrationUseCase $registrationUseCase;

    public function __construct(
        RegistrationUseCase $registrationUseCase
    ) {
        $this->registrationUseCase = $registrationUseCase;
    }

    public function registration(
        Request $request,
        LoginFormAuthenticator $authenticator,
        AuthenticationUtils $authenticationUtils,
        GuardAuthenticatorHandler $guardHandler,
        HtmlRegistrationPresenter $presenter,
        string $webappHost
    ): Response
    {

        if ($this->getUser()) {
            return $this->redirect($webappHost);
        }

        $errorMessage = '';
        $user = new User(
            null,
            null,
            null,
            ['ROLE_USER'],
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->registrationUseCase->handle(
                new RegistrationRequest(
                    $user,
                    (string) $request->request->get('first_password'),
                    (string) $request->request->get('second_password')
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

        return $this->render('security/registration.html.twig', [
            'errorMessage' => $errorMessage
        ]);
    }
}

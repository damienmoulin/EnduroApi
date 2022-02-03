<?php


namespace App\Controller\Security;


use App\Presenter\Authentication\HtmlAskResetPasswordPresenter;
use App\UseCase\Authentication\AskResetPasswordRequest;
use App\UseCase\Authentication\AskResetPasswordUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AskResetPasswordController extends AbstractController
{
    public function askResetPassword(
        Request $request,
        AskResetPasswordUseCase $useCase,
        HtmlAskResetPasswordPresenter $presenter
    ): Response
    {
        $errorMessage = '';
        if ($request->isMethod('POST')) {
            $useCase->handle(new AskResetPasswordRequest((string) $request->request->get('email')), $presenter);
            $viewModel = $presenter->getViewModel();
            if (!empty($viewModel->successMessage)) {
                $this->addFlash('success', $viewModel->successMessage);

                return $this->redirect($viewModel->redirectPath);
            } else {
                $errorMessage = $viewModel->error;
            }
        }

        return $this->render('security/ask_reset_password.html.twig', [
            'errorMessage' => $errorMessage,
        ]);
    }
}

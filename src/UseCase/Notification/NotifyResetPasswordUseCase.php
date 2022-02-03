<?php

declare(strict_types=1);

namespace App\UseCase\Notification;

use App\Domain\Notification\Email as EmailVO;
use App\Domain\Notification\EmailTemplateGateway;
use App\Domain\Notification\Exception\EmailTemplateNotFoundException;
use App\Domain\Notification\Exception\UserNotFoundException;
use App\Domain\Notification\Mailer;
use App\Domain\Notification\Router;
use App\Domain\Notification\User;
use App\Domain\Notification\UserGateway;
use App\Gateway\Authentication\PommUserGateway;
use App\Gateway\Notification\PommEmailTemplateGateway;
use App\UseCase\Component\EntityNotFoundError;
use App\UseCase\Component\UseCaseErrorResponse;
use App\UseCase\Component\ValidationError;
use App\UseCase\Component\ValidationException;
use Assert\Assert;
use Assert\InvalidArgumentException;

class NotifyResetPasswordUseCase
{
    private PommUserGateway $userGateway;
    private PommEmailTemplateGateway $emailTemplateGateway;
    private Router $router;
    private Mailer $mailer;
    private string $emailAuthor;
    private ?User $user = null;

    public function __construct(
        PommUserGateway $userGateway,
        PommEmailTemplateGateway $emailTemplateGateway,
        Router $router,
        Mailer $mailer,
        string $emailAuthor
    ) {
        $this->userGateway = $userGateway;
        $this->emailTemplateGateway = $emailTemplateGateway;
        $this->router = $router;
        $this->mailer = $mailer;
        $this->emailAuthor = $emailAuthor;
    }

    public function handle(NotifyResetPasswordRequest $request, NotifyResetPasswordPresenter $presenter): void
    {
        try {
            $this->validate($request);
            $email = EmailVO::createFromTemplate(
                $this->emailAuthor,
                $this->user->email,
                $this->emailTemplateGateway->getResetPasswordTemplate(),
                ['resetPasswordLink' => $this->router->getResetPasswordLink($this->user->resetPasswordToken)]
            );
            $this->mailer->send($email);
            $response = new NotifyResetPasswordResponse(new Email(
                $email->author,
                $email->recipient,
                $email->subject,
                $email->body,
                $email->carbonCopyRecipient
            ));
        } catch (ValidationException $exception) {
            $response = new UseCaseErrorResponse($exception->getErrors());
        } catch (EmailTemplateNotFoundException $exception) {
            $response = new UseCaseErrorResponse([new EntityNotFoundError($exception->getMessage())]);
        }
        $presenter->present($response);
    }

    /**
     * @psalm-assert User $this->user
     * @psalm-assert string $this->user->resetPasswordToken
     */
    private function validate(NotifyResetPasswordRequest $request): void
    {
        try {
            $this->user = $this->userGateway->get($request->userId);
            Assert::that($this->user->resetPasswordToken)
                ->notBlank('User without reset password token');
        } catch (UserNotFoundException | InvalidArgumentException $exception) {
            throw new ValidationException([new ValidationError('userId', $exception->getMessage())]);
        }
    }
}

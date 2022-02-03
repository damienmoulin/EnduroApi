<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

use App\Domain\Authentication\Exception\UserNotFoundException;
use App\Domain\Authentication\UserGateway;
use App\UseCase\Component\UseCaseErrorResponse;
use App\UseCase\Component\ValidationError;
use App\UseCase\Component\ValidationException;
use App\UseCase\Notification\NotifyResetPasswordPresenter;
use App\UseCase\Notification\NotifyResetPasswordRequest;
use App\UseCase\Notification\NotifyResetPasswordUseCase;
use Assert\Assert;
use Assert\InvalidArgumentException;

class AskResetPasswordUseCase
{
    private UserGateway $userGateway;
    private NotifyResetPasswordUseCase $notifyResetPasswordUseCase;
    private NotifyResetPasswordPresenter $sideEventPresenter;

    public function __construct(
        UserGateway $userGateway,
        NotifyResetPasswordUseCase $notifyResetPasswordUseCase,
        NotifyResetPasswordPresenter $sideEventPresenter
    ) {
        $this->userGateway = $userGateway;
        $this->notifyResetPasswordUseCase = $notifyResetPasswordUseCase;
        $this->sideEventPresenter = $sideEventPresenter;
    }

    public function handle(AskResetPasswordRequest $request, AskResetPasswordPresenter $presenter): void
    {
        try {
            $this->validate($request);
            $user = $this->userGateway->getByEmail($request->email)->withNewConfirmationToken();
            $this->userGateway->update($user);
            $this->notifyResetPasswordUseCase->handle(new NotifyResetPasswordRequest($user->id), $this->sideEventPresenter);
            $response = new AskResetPasswordResponse();
        } catch (ValidationException $exception) {
            $response = new UseCaseErrorResponse($exception->getErrors());
        } catch (UserNotFoundException $exception) {
            $response = new AskResetPasswordResponse();
        }
        $presenter->present($response);
    }

    private function validate(AskResetPasswordRequest $request): void
    {
        try {
            Assert::that($request->email)
                ->email('Invalid email', 'email');
        } catch (InvalidArgumentException $exception) {
            throw new ValidationException([new ValidationError((string) $exception->getPropertyPath(), $exception->getMessage())]);
        }
    }
}

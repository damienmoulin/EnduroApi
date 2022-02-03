<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

use App\Domain\Authentication\Exception\InvalidPasswordException;
use App\Domain\Authentication\Exception\PasswordPolicyNotFoundException;
use App\Domain\Authentication\Exception\UserNotFoundException;
use App\Domain\Authentication\PasswordEncoder;
use App\Domain\Authentication\PasswordPolicyGateway;
use App\Domain\Authentication\UserGateway;
use App\UseCase\Component\EntityNotFoundError;
use App\UseCase\Component\UseCaseErrorResponse;
use App\UseCase\Component\ValidationError;
use App\UseCase\Component\ValidationException;
use Assert\Assert;
use Assert\InvalidArgumentException;

class ResetPasswordUseCase
{
    private UserGateway $userGateway;
    private PasswordEncoder $passwordEncoder;
    private PasswordPolicyGateway $passwordPolicyGateway;

    public function __construct(UserGateway $userGateway, PasswordEncoder $passwordEncoder, PasswordPolicyGateway $passwordPolicyGateway)
    {
        $this->userGateway = $userGateway;
        $this->passwordEncoder = $passwordEncoder;
        $this->passwordPolicyGateway = $passwordPolicyGateway;
    }

    public function handle(ResetPasswordRequest $request, ResetPasswordPresenter $presenter): void
    {
        try {
            $user = $this->userGateway->getByConfirmationToken($request->confirmationToken);
            $this->validate($request);
            $user = $user->updatePassword($this->passwordEncoder->encode($request->firstPassword));
            $this->userGateway->update($user);
            $response = new ResetPasswordResponse(new User(
                $user->id,
                $user->email,
                $user->password,
                $user->roles
            ));
        } catch (UserNotFoundException | PasswordPolicyNotFoundException $exception) {
            $response = new UseCaseErrorResponse([new EntityNotFoundError($exception->getMessage())]);
        } catch (ValidationException $exception) {
            $response = new UseCaseErrorResponse($exception->getErrors());
        }
        $presenter->present($response);
    }

    private function validate(ResetPasswordRequest $request): void
    {
        try {
            Assert::that($request->firstPassword)
                ->notBlank('Empty password', 'password');
            Assert::that($request->firstPassword)
                ->eq($request->secondPassword, 'Password mismatch', 'password');
            /** @psalm-suppress UnusedMethodCall */
            $this->passwordPolicyGateway->getActivePasswordPolicy()->validate($request->firstPassword);
        } catch (InvalidArgumentException $exception) {
            throw new ValidationException([new ValidationError((string) $exception->getPropertyPath(), $exception->getMessage())]);
        } catch (InvalidPasswordException $exception) {
            throw new ValidationException([new ValidationError('password', $exception->getMessage())]);
        }
    }
}

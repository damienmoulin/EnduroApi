<?php


namespace App\UseCase\Authentication;


use App\Domain\Authentication\Exception\InvalidPasswordException;
use App\Domain\Authentication\Exception\PasswordPolicyNotFoundException;
use App\Domain\Authentication\PasswordEncoder;
use App\Domain\Authentication\PasswordPolicyGateway;
use App\Domain\Authentication\UserGateway;
use App\UseCase\Component\EntityNotFoundError;
use App\UseCase\Component\UseCaseErrorResponse;
use App\UseCase\Component\ValidationError;
use App\UseCase\Component\ValidationException;
use Assert\Assert;
use Assert\InvalidArgumentException;

class RegistrationUseCase
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

    public function handle(
        RegistrationRequest $request,
        RegistrationPresenter $registrationPresenter
    ): \App\Domain\Authentication\User {
        try {

            $this->validate($request);
            $request->user->roles = ['ROLE_USER'];
            $request->user->password = $this->passwordEncoder->encode($request->firstPassword);
            $request->user->withNewConfirmationToken();

            $user = $this->userGateway->insert($request->user);

            $response = new RegistrationResponse($user);

        } catch (PasswordPolicyNotFoundException $exception) {
            $response = new UseCaseErrorResponse([new EntityNotFoundError($exception->getMessage())]);
        } catch (ValidationException $exception) {
            $response = new UseCaseErrorResponse($exception->getErrors());
        }

        $registrationPresenter->present($response);
    }

    private function validate(RegistrationRequest $request): void
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

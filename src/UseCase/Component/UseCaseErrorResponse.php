<?php

declare(strict_types=1);

namespace App\UseCase\Component;

/** @psalm-immutable */
class UseCaseErrorResponse
{
    /** @var list<UseCaseError> */
    public array $errors;

    /**
     * @param list<UseCaseError> $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function hasUnauthorizedErrors(): bool
    {
        foreach ($this->errors as $error) {
            if ($error instanceof UnauthorizedError) {
                return true;
            }
        }

        return false;
    }

    public function hasNotFoundErrors(): bool
    {
        foreach ($this->errors as $error) {
            if ($error instanceof EntityNotFoundError) {
                return true;
            }
        }

        return false;
    }
}

<?php

declare(strict_types=1);

namespace App\UseCase\Component;

use RuntimeException;

class ValidationException extends RuntimeException
{
    /** @var non-empty-list<ValidationError> */
    private array $errors;

    /**
     * @param non-empty-list<ValidationError> $errors
     */
    public function __construct(array $errors)
    {
        parent::__construct();
        $this->errors = $errors;
    }

    /**
     * @return non-empty-list<ValidationError>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}

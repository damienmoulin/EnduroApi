<?php

declare(strict_types=1);

namespace App\UseCase\Component;

/** @psalm-immutable */
class ValidationError implements UseCaseError
{
    private string $property;
    private string $message;

    public function __construct(string $property, string $message)
    {
        $this->property = $property;
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}

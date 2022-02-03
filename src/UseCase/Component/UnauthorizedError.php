<?php

declare(strict_types=1);

namespace App\UseCase\Component;

class UnauthorizedError implements UseCaseError
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getProperty(): ?string
    {
        return null;
    }
}

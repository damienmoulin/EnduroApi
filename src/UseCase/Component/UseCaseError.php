<?php

declare(strict_types=1);

namespace App\UseCase\Component;

interface UseCaseError
{
    public function getMessage(): string;

    public function getProperty(): ?string;
}

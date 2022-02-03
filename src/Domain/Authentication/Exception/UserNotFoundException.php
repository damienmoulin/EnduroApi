<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Exception;

use RuntimeException;

class UserNotFoundException extends RuntimeException
{
    public static function createFromEmail(string $email, \Exception $previous = null): self
    {
        return new self(
            sprintf('User not found for email "%s"', $email),
            0,
            $previous
        );
    }

    public static function createFromToken(string $token, \Exception $previous = null): self
    {
        return new self(
            sprintf('User not found for token "%s"', $token),
            0,
            $previous
        );
    }
}

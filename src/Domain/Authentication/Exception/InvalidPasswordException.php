<?php

declare(strict_types=1);

namespace App\Domain\Authentication\Exception;

use RuntimeException;

class InvalidPasswordException extends RuntimeException
{
    public static function createFromMaxLength(int $maxLength, \Exception $previous = null): self
    {
        return new self(
            sprintf('Password length should not exceed %d characters', $maxLength),
            0,
            $previous
        );
    }

    public static function createFromMinLength(int $minLength, \Exception $previous = null): self
    {
        return new self(
            sprintf('Password should have at least %d characters', $minLength),
            0,
            $previous
        );
    }

    public static function createFromLowerCaseCharacterPolicy(\Exception $previous = null): self
    {
        return new self(
            'Password should have at least one lower case character',
            0,
            $previous
        );
    }

    public static function createFromUpperCaseCharacterPolicy(\Exception $previous = null): self
    {
        return new self(
            'Password should have at least one upper case character',
            0,
            $previous
        );
    }

    public static function createFromDigitCharacterPolicy(\Exception $previous = null): self
    {
        return new self(
            'Password should have at least one digit character',
            0,
            $previous
        );
    }

    public static function createFromSimilarCharacterPolicy(array $disallowedCharacters, \Exception $previous = null): self
    {
        return new self(
            sprintf('Password should not have characters which appear to be similar to another one (%s)', implode(' ', $disallowedCharacters)),
            0,
            $previous
        );
    }

    public static function createFromSpecialCharacterPolicy(array $specialCharacters, \Exception $previous = null): self
    {
        return new self(
            sprintf('Password should have at least one of the following special characters ( %s )', implode('', $specialCharacters)),
            0,
            $previous
        );
    }
}

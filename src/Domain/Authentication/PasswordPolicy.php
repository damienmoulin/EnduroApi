<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use App\Domain\Authentication\Exception\InvalidPasswordException;

/** @psalm-immutable */
class PasswordPolicy
{
    private const MAX_LENGTH = 72;
    private const SIMILAR_CHARACTERS = ['0', 'O', 'o', '1', 'l', 'I'];
    private const SPECIAL_CHARACTERS = ['-', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '+', '[', ']', '{', '}', ';', ':', '.', '<', '>', '/', '?'];

    private int $minLength;
    private bool $lowerCaseCharacterRequired;
    private bool $upperCaseCharacterRequired;
    private bool $digitCharacterRequired;
    private bool $similarCharactersDisallowed;
    private bool $specialCharacterRequired;

    public function __construct(int $minLength, bool $lowerCaseCharacterRequired, bool $upperCaseCharacterRequired, bool $digitCharacterRequired, bool $similarCharactersDisallowed, bool $specialCharacterRequired)
    {
        $this->minLength = $minLength;
        $this->lowerCaseCharacterRequired = $lowerCaseCharacterRequired;
        $this->upperCaseCharacterRequired = $upperCaseCharacterRequired;
        $this->digitCharacterRequired = $digitCharacterRequired;
        $this->similarCharactersDisallowed = $similarCharactersDisallowed;
        $this->specialCharacterRequired = $specialCharacterRequired;
    }

    /**
     * @psalm-suppress UnusedMethodCall
     */
    public function validate(string $password): void
    {
        $this->validateMaxLength($password);
        $this->validateMinLength($password);
        $this->validateLowerCaseCharacterPolicy($password);
        $this->validateUpperCaseCharacterPolicy($password);
        $this->validateDigitCharacterPolicy($password);
        $this->validateSimilarCharactersPolicy($password);
        $this->validateSpecialCharacterPolicy($password);
    }

    private function validateMaxLength(string $password): void
    {
        if (\strlen($password) > self::MAX_LENGTH) {
            throw InvalidPasswordException::createFromMaxLength(self::MAX_LENGTH);
        }
    }

    private function validateMinLength(string $password): void
    {
        if (\strlen($password) < $this->minLength) {
            throw InvalidPasswordException::createFromMinLength($this->minLength);
        }
    }

    private function validateLowerCaseCharacterPolicy(string $password): void
    {
        if ($this->lowerCaseCharacterRequired && 1 !== preg_match('/[a-z]/', $password)) {
            throw InvalidPasswordException::createFromLowerCaseCharacterPolicy();
        }
    }

    private function validateUpperCaseCharacterPolicy(string $password): void
    {
        if ($this->upperCaseCharacterRequired && 1 !== preg_match('/[A-Z]/', $password)) {
            throw InvalidPasswordException::createFromUpperCaseCharacterPolicy();
        }
    }

    private function validateDigitCharacterPolicy(string $password): void
    {
        if ($this->digitCharacterRequired && 1 !== preg_match('/[0-9]/', $password)) {
            throw InvalidPasswordException::createFromDigitCharacterPolicy();
        }
    }

    private function validateSimilarCharactersPolicy(string $password): void
    {
        $regex = sprintf('/[%s]/', implode('', self::SIMILAR_CHARACTERS));
        if ($this->similarCharactersDisallowed && 1 === preg_match($regex, $password)) {
            throw InvalidPasswordException::createFromSimilarCharacterPolicy(self::SIMILAR_CHARACTERS);
        }
    }

    private function validateSpecialCharacterPolicy(string $password): void
    {
        $regex = sprintf('/[%s]/', preg_quote(implode('', self::SPECIAL_CHARACTERS), '/'));
        if ($this->specialCharacterRequired && 1 !== preg_match($regex, $password)) {
            throw InvalidPasswordException::createFromSpecialCharacterPolicy(self::SPECIAL_CHARACTERS);
        }
    }
}

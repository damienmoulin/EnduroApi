<?php

declare(strict_types=1);

namespace App\Domain\Notification;

/** @psalm-immutable */
class User
{
    public int $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public ?string $passwordInitializationToken;
    public ?string $resetPasswordToken;
    public bool $isProspect;

    public function __construct(
        int $id,
        string $email,
        string $firstName,
        string $lastName,
        ?string $passwordInitializationToken = null,
        ?string $resetPasswordToken = null,
        bool $isProspect = false
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->passwordInitializationToken = $passwordInitializationToken;
        $this->resetPasswordToken = $resetPasswordToken;
        $this->isProspect = $isProspect;
    }
}

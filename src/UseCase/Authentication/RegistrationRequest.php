<?php


namespace App\UseCase\Authentication;

use App\Domain\Authentication\User;

class RegistrationRequest
{
    public User $user;
    public string $firstPassword;
    public string $secondPassword;

    public function __construct(
        User $user,
        string $firstPassword,
        string $secondPassword
    ) {
        $this->user = $user;
        $this->firstPassword = $firstPassword;
        $this->secondPassword = $secondPassword;
    }
}

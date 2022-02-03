<?php


namespace App\UseCase\Authentication;

use App\Domain\Authentication\User;

class RegistrationResponse
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

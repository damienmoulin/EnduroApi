<?php


namespace App\Presenter\Authentication;


use App\Domain\Authentication\User;

class HtmlRegistrationViewModel
{
    public ?User $userToLogIn;
    public string $error;

    public function __construct(?\App\Infrastructure\Authentication\User $userToLogIn, string $error)
    {
        $this->userToLogIn = $userToLogIn;
        $this->error = $error;
    }
}

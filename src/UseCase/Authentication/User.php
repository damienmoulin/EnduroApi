<?php

declare(strict_types=1);

namespace App\UseCase\Authentication;

/** @psalm-immutable */
class User
{
    public int $id;
    public string $email;
    public string $password;
    /** @var list<string> */
    public array $roles;
    public string $firstname;
    public string $lastname;

    /**
     * @param list<string> $roles
     */
    public function __construct(
        int $id,
        string $email,
        string $password,
        array $roles,
        string $firstname,
        string $lastname
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
}

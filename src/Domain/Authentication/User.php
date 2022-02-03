<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

/** @psalm-immutable */
class User
{
    public ?int $id;
    public ?string $email;
    public ?string $password;
    /**
     * @psalm-var list<string>
     */
    public array $roles;
    public ?string $confirmationToken;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $address;
    public ?string $city;
    public ?string $zipcode;
    public ?string $phone;

    /**
     * @param int $id
     * @param string $email
     * @param string $password
     * @psalm-param list<string> $roles
     * @param string|null $confirmationToken
     * @param string|null $firstname
     * @param string|null $lastname
     * @param string|null $address
     * @param string|null $city
     * @param string|null $zipcode
     * @param string|null $phone
     */
    public function __construct(
        ?int $id,
        ?string $email,
        ?string $password,
        array $roles = ['ROLE_USER'],
        ?string $confirmationToken = null,
        ?string $firstname = null,
        ?string $lastname = null,
        ?string $address = null,
        ?string $city = null,
        ?string $zipcode = null,
        ?string $phone = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
        $this->confirmationToken = $confirmationToken;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->phone = $phone;
    }

    public function updatePassword(string $password): self
    {
        return new self(
            $this->id,
            $this->email,
            $password,
            $this->roles,
            $this->firstname,
            $this->lastname,
            $this->address,
            $this->city,
            $this->zipcode,
            $this->phone,
        );
    }

    public function withNewConfirmationToken(): self
    {
        // @psalm-suppress ImpureFunctionCall
        return new self(
            $this->id,
            $this->email,
            $this->password,
            $this->roles,
            bin2hex(random_bytes(16)),
            $this->firstname,
            $this->lastname,
            $this->address,
            $this->city,
            $this->zipcode,
            $this->phone,
        );
    }
}

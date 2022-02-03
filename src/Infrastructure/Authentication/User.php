<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use App\Domain\Authentication\User as UserEntity;
use App\UseCase\Authentication\User as UserDTO;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface, \JsonSerializable
{
    private int $id;
    private string $email;
    /** @var list<string> */
    private array $roles;
    private string $password;

    private string $firstname;
    private string $lastname;

    /**
     * @param list<string> $roles
     */
    public function __construct(
        int $id,
        string $email,
        array $roles,
        string $password,
        string $firstname,
        string $lastname
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->roles = $roles;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'roles' => $this->roles,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return null|string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return null|string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public static function createFromUserEntity(UserEntity $user): self
    {
        return new self(
            $user->id,
            $user->email,
            $user->roles,
            $user->password,
            $user->firstname,
            $user->lastname
        );
    }

    public static function createFromUserDTO(UserDTO $user): self
    {
        return new self(
            $user->id,
            $user->email,
            $user->roles,
            $user->password,
            $user->firstname,
            $user->lastname
        );
    }
}

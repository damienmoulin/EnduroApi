<?php

declare(strict_types=1);

namespace App\Gateway\Authentication;

use App\Domain\Authentication\Exception\UserNotFoundException;
use App\Domain\Authentication\User;
use App\Domain\Authentication\UserGateway;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\SimpleQueryManager;

class PommUserGateway implements UserGateway
{
    private SimpleQueryManager $queryManager;

    public function __construct(Pomm $pomm)
    {
        $this->queryManager = $pomm->getDefaultSession()->getQueryManager();
    }

    public function getByEmail(string $email): User
    {
        $sql = <<<'SQL'
SELECT
    user_id,
    email,
    password,
    roles,
    confirmation_token, 
    firstname,
    lastname,
    address,
    zipcode,
    city,
    phone   
FROM "user"
WHERE email ILIKE $*
SQL;
        $result = $this->queryManager->query($sql, [$email]);
        if ($result->isEmpty()) {
            throw UserNotFoundException::createFromEmail($email);
        }
        /** @psalm-var array{user_id: int, email: string, password: ?string, roles: list<string>, confirmation_token: ?string} $plainUser */
        $plainUser = $result->current();

        return new User(
            $plainUser['user_id'],
            $plainUser['email'],
            (string) $plainUser['password'],
            $plainUser['roles'],
            $plainUser['confirmation_token'],
            $plainUser['firstname'],
            $plainUser['lastname'],
            $plainUser['address'],
            $plainUser['city'],
            $plainUser['zipcode'],
            $plainUser['phone']
        );
    }

    public function getByConfirmationToken(string $confirmationToken): User
    {
        $sql = <<<'SQL'
SELECT
    user_id,
    email,
    password,
    roles,
    confirmation_token
FROM "user"
WHERE confirmation_token = $*
SQL;
        $result = $this->queryManager->query($sql, [$confirmationToken]);
        if ($result->isEmpty()) {
            throw UserNotFoundException::createFromToken($confirmationToken);
        }
        /** @psalm-var array{user_id: int, email: string, password: ?string, roles: list<string>, confirmation_token: ?string} $plainUser */
        $plainUser = $result->current();

        return new User(
            $plainUser['user_id'],
            $plainUser['email'],
            (string) $plainUser['password'],
            $plainUser['roles'],
            $plainUser['confirmation_token']
        );
    }

    public function insert(User $user): User
    {
        $sql = <<<'SQL'
INSERT INTO "user"
    (
     email,
     roles,
     password,
     confirmation_token,
     firstname,
     lastname,
     address,
     city,
     zipcode,
     phone
    )
VALUES
    (
     :email,
     :roles,
     :password,
     :confirmation_token,
     :firstname,
     :lastname,
     :address,
     :city,
     :zipcode,
     :phone
    )
SQL;

        $this->queryManager->query(strtr(
            $sql,
            [
                ':email' => $user->email,
                ':roles' => $user->roles,
                ':password' => $user->password,
                ':confirmation_token' => $user->confirmationToken,
                ':firstname' => $user->firstname,
                ':lastname' => $user->lastname,
                ':address' => $user->address,
                ':city' => $user->city,
                ':zipcode' => $user->zipcode,
                ':phone' => $user->phone,
            ]
        ), []);

        return $user;
    }

    public function update(User $user): void
    {
        $sql = <<<'SQL'
UPDATE "user"
SET email = $*,
    password = $*,
    roles = $*::varchar[],
    confirmation_token = $*
WHERE user_id = $*
SQL;
        $this->queryManager->query($sql, [
            $user->email,
            $user->password,
            $user->roles,
            $user->confirmationToken,
            $user->id,
        ]);
    }
}

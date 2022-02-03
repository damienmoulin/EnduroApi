<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use App\Domain\Authentication\Exception\UserNotFoundException;

interface UserGateway
{
    public function insert(User $user): User;

    /** @throws UserNotFoundException */
    public function getByEmail(string $email): User;

    /** @throws UserNotFoundException */
    public function getByConfirmationToken(string $confirmationToken): User;

    public function update(User $user): void;
}

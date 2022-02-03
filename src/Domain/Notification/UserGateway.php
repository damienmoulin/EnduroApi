<?php

declare(strict_types=1);

namespace App\Domain\Notification;

use App\Domain\Notification\Exception\UserNotFoundException;

interface UserGateway
{
    /** @throws UserNotFoundException */
    public function get(int $id): User;

    /** @throws UserNotFoundException */
    public function getAdvisor(int $id): User;
}

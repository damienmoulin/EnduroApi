<?php

declare(strict_types=1);

namespace App\Domain\Notification;

interface DossierGateway
{
    public function exists(string $id): bool;
}

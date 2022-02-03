<?php

declare(strict_types=1);

namespace App\Domain\Notification;

interface Mailer
{
    public function send(Email $email): void;
}

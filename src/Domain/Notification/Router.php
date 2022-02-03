<?php

declare(strict_types=1);

namespace App\Domain\Notification;

interface Router
{
    public function getDossierAccessLinkForNewUser(string $dossierId, string $passwordInitializationToken): string;

    public function getDossierAccessLink(string $dossierId): string;

    public function getResetPasswordLink(string $resetPasswordToken): string;

    public function getWebAppLink(): string;
}

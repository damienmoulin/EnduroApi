<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Notification\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SymfonyRouter implements Router
{
    private const WEBAPP_DOSSIER_ROUTE = '/dossier/{dossierId}';

    private UrlGeneratorInterface $urlGenerator;
    private string $webappHost;

    public function __construct(UrlGeneratorInterface $urlGenerator, string $webappHost)
    {
        $this->urlGenerator = $urlGenerator;
        $this->webappHost = $webappHost;
    }

    public function getDossierAccessLinkForNewUser(string $dossierId, string $passwordInitializationToken): string
    {
        return $this->urlGenerator->generate('app_first_login', [
            'confirmation_token' => $passwordInitializationToken,
            'redirect_uri' => $this->getDossierAccessLink($dossierId),
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getDossierAccessLink(string $dossierId): string
    {
        return $this->webappHost.str_replace('{dossierId}', $dossierId, self::WEBAPP_DOSSIER_ROUTE);
    }

    public function getResetPasswordLink(string $resetPasswordToken): string
    {
        return $this->urlGenerator->generate('reset_password', [
            'passwordToken' => $resetPasswordToken,
        ], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function getWebAppLink(): string
    {
        return $this->webappHost;
    }
}

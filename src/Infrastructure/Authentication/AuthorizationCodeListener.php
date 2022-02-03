<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use Nyholm\Psr7\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Trikoder\Bundle\OAuth2Bundle\Event\AuthorizationRequestResolveEvent;

final class AuthorizationCodeListener
{
    use TargetPathTrait;

    const FIREWALL_NAME = 'main';

    private UrlGeneratorInterface $urlGenerator;
    private RequestStack $requestStack;
    private SessionInterface $session;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        RequestStack $requestStack,
        SessionInterface $session
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
        $this->session = $session;
    }

    public function onAuthorizationRequestResolve(AuthorizationRequestResolveEvent $event): void
    {
        if (null !== $event->getUser()) {
            $event->resolveAuthorization(AuthorizationRequestResolveEvent::AUTHORIZATION_APPROVED);
        } else {
            /** @var Request $request */
            $request = $this->requestStack->getMasterRequest();
            $this->saveTargetPath($this->session, self::FIREWALL_NAME, $request->getUri());
            $event->setResponse(
                new Response(302, [
                    'Location' => $this->urlGenerator->generate('app_login'),
                ])
            );
        }
    }
}

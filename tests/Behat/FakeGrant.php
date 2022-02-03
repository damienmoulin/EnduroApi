<?php


namespace App\Tests\Behat;


use App\Phinx\Seeds\Auth1;
use App\Phinx\Seeds\Auth2;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Grant\AbstractGrant;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
final class FakeGrant extends AbstractGrant
{
    public function __construct(
        ClientRepositoryInterface $clientRepository,
        AccessTokenRepositoryInterface $accessTokenRepository,
        KernelInterface $appKernel
    )
    {
        $this->setClientRepository($clientRepository);
        $this->setAccessTokenRepository($accessTokenRepository);
        $this->setPrivateKey(new CryptKey($appKernel->getProjectDir().'/private.key', null, false));
    }

    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }

    public function respondToAccessTokenRequest(ServerRequestInterface $request, ResponseTypeInterface $responseType, \DateInterval $accessTokenTTL)
    {
        // TODO: Implement respondToAccessTokenRequest() method.
    }

    public function getAccessToken(string $email)
    {
        return $this->issueAccessToken(
            new \DateInterval('PT1H'),
            $this->clientRepository->getClientEntity(Auth1::WEBAPP_CLIENT_ID),
            $email
        );
    }
}
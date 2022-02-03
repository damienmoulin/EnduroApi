<?php


namespace App\Tests\Behat;


use App\Phinx\Seeds\Auth1;
use App\Phinx\Seeds\Auth2;
use App\Phinx\Seeds\AuthenticationSeeder;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkContext;
use Behatch\Context\RestContext;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AuthenticationContext implements Context
{
    protected RestContext $restContext;
    protected ?int $loggedInUserId = null;
    protected FakeGrant $fakeGrant;

    public function __construct(
        FakeGrant $fakeGrant
    )
    {
        $this->fakeGrant = $fakeGrant;
    }

    /** @BeforeScenario */
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $this->minkContext = $environment->getContext(MinkContext::class);
        $this->restContext = $environment->getContext(RestContext::class);
    }

    /**
     * @Given I am a backoffice
     */
    public function iAmABackoffice()
    {
        $this->loginAs(Auth1::BACK_OFFICE_USER_ID, Auth1::BACK_OFFICE_USER_EMAIL);
    }

    private function loginAs(int $userId, string $email): void
    {
        $accessToken = (string) $this->fakeGrant->getAccessToken($email);
        $this->restContext->iAddHeaderEqualTo('Authorization', sprintf('Bearer %s', $accessToken));
        $this->loggedInUserId = $userId;
    }
}
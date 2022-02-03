<?php

declare(strict_types=1);

namespace App\Gateway\Notification;

use App\Domain\Notification\EmailTemplate;
use App\Domain\Notification\EmailTemplateGateway;
use App\Domain\Notification\Exception\EmailTemplateNotFoundException;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\SimpleQueryManager;

class PommEmailTemplateGateway implements EmailTemplateGateway
{
    public const DOSSIER_ACCESS_EXISTING_USER = 'send_acces_esous_client';
    public const DOSSIER_ACCESS_NEW_USER = 'send_acces_esous_prosp';
    public const RESET_PASSWORD = 'ask_password_sous';
    public const NOTIFY_NEW_LINK_ACCESS_TO_PROSPECT_AND_ADVISOR = 'notify_new_link_access_to_prospect_and_advisor';

    private SimpleQueryManager $queryManager;

    public function __construct(Pomm $pomm)
    {
        $this->queryManager = $pomm->getDefaultSession()->getQueryManager();
    }

    public function getDossierAccessTemplateForExistingUser(): EmailTemplate
    {
        return $this->getEmailTemplate(self::DOSSIER_ACCESS_EXISTING_USER);
    }

    /**
     * @throws EmailTemplateNotFoundException
     */
    private function getEmailTemplate(string $code): EmailTemplate
    {
        $sql = <<<'SQL'
SELECT
    sujet,
    message
FROM alerte
WHERE code = $*
SQL;
        $result = $this->queryManager->query($sql, [$code]);
        if ($result->isEmpty()) {
            throw new EmailTemplateNotFoundException(sprintf('Email template not found for code "%s"', $code));
        }
        /** @psalm-var array{sujet: ?string, message: ?string} $plainEmailTemplate */
        $plainEmailTemplate = $result->current();

        return new EmailTemplate((string) $plainEmailTemplate['sujet'], (string) $plainEmailTemplate['message']);
    }

    public function getDossierAccessTemplateForNewUser(): EmailTemplate
    {
        return $this->getEmailTemplate(self::DOSSIER_ACCESS_NEW_USER);
    }

    public function getResetPasswordTemplate(): EmailTemplate
    {
        return $this->getEmailTemplate(self::RESET_PASSWORD);
    }

    public function getNotifyNewLinkAccessToProspectAndAdvisorTemplate(): EmailTemplate
    {
        return $this->getEmailTemplate(self::NOTIFY_NEW_LINK_ACCESS_TO_PROSPECT_AND_ADVISOR);
    }
}

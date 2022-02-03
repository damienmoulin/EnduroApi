<?php

declare(strict_types=1);

namespace App\Domain\Notification;

use App\Domain\Notification\Exception\EmailTemplateNotFoundException;

interface EmailTemplateGateway
{
    /** @throws EmailTemplateNotFoundException */
    public function getDossierAccessTemplateForExistingUser(): EmailTemplate;

    /** @throws EmailTemplateNotFoundException */
    public function getDossierAccessTemplateForNewUser(): EmailTemplate;

    /** @throws EmailTemplateNotFoundException */
    public function getResetPasswordTemplate(): EmailTemplate;

    /** @throws EmailTemplateNotFoundException */
    public function getNotifyNewLinkAccessToProspectAndAdvisorTemplate(): EmailTemplate;
}

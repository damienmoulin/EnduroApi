<?php

declare(strict_types=1);

namespace App\Presenter\Component;

use App\UseCase\Component\UseCaseErrorResponse;
use App\UseCase\Form\UpdateDossiersClientFromEmailPresenter;
use App\UseCase\Form\UpdateDossiersClientFromEmailResponse;
use App\UseCase\Notification\NotifyDossierAccessToUserPresenter;
use App\UseCase\Notification\NotifyDossierAccessToUserResponse;
use App\UseCase\Notification\NotifyNewLinkAccessToProspectAndAdvisorPresenter;
use App\UseCase\Notification\NotifyNewLinkAccessToProspectAndAdvisorResponse;
use App\UseCase\Notification\NotifyResetPasswordPresenter;
use App\UseCase\Notification\NotifyResetPasswordResponse;
use Psr\Log\LoggerInterface;

class SideEventPresenter implements NotifyResetPasswordPresenter
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param UseCaseErrorResponse|NotifyResetPasswordResponse $response
     */
    public function present($response): void
    {
        if ($response instanceof UseCaseErrorResponse) {
            foreach ($response->errors as $error) {
                $this->logger->error($error->getMessage());
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Notification;

use App\Domain\Notification\Email;
use App\Domain\Notification\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as SymfonyEmail;

class SymfonyMailer implements Mailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Email $email): void
    {
        $symfonyEmail = (new SymfonyEmail())
            ->from($email->author)
            ->to($email->recipient)
            ->subject($email->subject)
            ->html($email->body);
        if ($email->carbonCopyRecipient) {
            $symfonyEmail->addCc($email->carbonCopyRecipient);
        }

        $this->mailer->send($symfonyEmail);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Notification;

/** @psalm-immutable */
class EmailTemplate
{
    public string $subject;
    public string $body;

    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Notification;

/** @psalm-immutable */
class Email
{
    public string $author;
    public string $recipient;
    public string $subject;
    public string $body;
    public ?string $carbonCopyRecipient;

    private function __construct(string $author, string $recipient, string $subject, string $body, ?string $carbonCopyRecipient = null)
    {
        $this->author = $author;
        $this->recipient = $recipient;
        $this->subject = $subject;
        $this->body = $body;
        $this->carbonCopyRecipient = $carbonCopyRecipient;
    }

    /**
     * @param array<string, string> $values
     */
    public static function createFromTemplate(
        string $author,
        string $recipient,
        EmailTemplate $emailTemplate,
        array $values,
        ?string $carbonCopyRecipient = null
    ): self {
        $placeholders = array_map(
            fn (string $key): string => sprintf('[%s]', $key),
            array_keys($values)
        );

        return new self(
            $author,
            $recipient,
            str_replace($placeholders, $values, $emailTemplate->subject),
            str_replace($placeholders, $values, $emailTemplate->body),
            $carbonCopyRecipient
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\Notification\Exception;

use RuntimeException;

class UserNotFoundException extends RuntimeException
{
    public static function createFromId(int $id, \Exception $previous = null): self
    {
        return new self(
            sprintf('User not found for id "%d"', $id),
            0,
            $previous
        );
    }

    public static function createFromProspectWithoutAdvisor(int $prospectId, \Exception $previous = null): self
    {
        return new self(
            sprintf('Advisor not found for prospect "%d"', $prospectId),
            0,
            $previous
        );
    }
}

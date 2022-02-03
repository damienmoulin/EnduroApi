<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

use App\Domain\Authentication\Exception\PasswordPolicyNotFoundException;

interface PasswordPolicyGateway
{
    /** @throws PasswordPolicyNotFoundException */
    public function getActivePasswordPolicy(): PasswordPolicy;
}

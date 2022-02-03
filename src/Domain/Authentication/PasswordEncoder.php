<?php

declare(strict_types=1);

namespace App\Domain\Authentication;

interface PasswordEncoder
{
    public function encode(string $plainPassword): string;
}

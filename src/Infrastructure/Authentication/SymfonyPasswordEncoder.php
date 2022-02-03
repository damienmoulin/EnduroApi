<?php

declare(strict_types=1);

namespace App\Infrastructure\Authentication;

use App\Domain\Authentication\PasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SymfonyPasswordEncoder implements PasswordEncoder
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function encode(string $plainPassword): string
    {
        $nullUser = new User(0, '', [], '');

        return $this->passwordEncoder->encodePassword($nullUser, $plainPassword);
    }
}

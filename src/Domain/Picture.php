<?php


namespace App\Domain;


class Picture
{
    public ?string $pathname;
    public bool $main = false;

    public function __construct(
        ?string $pathname = null,
        bool $main = false
    ) {
        $this->pathname = $pathname;
        $this->main = $main;
    }
}

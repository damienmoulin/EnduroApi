<?php


namespace App\Domain\Utils;


class BoolFormater
{
    public static function getPostgresqlBoolFormat(?bool $bool)
    {
        if ($bool) {
            return 1;
        }

        return 0;
    }
}

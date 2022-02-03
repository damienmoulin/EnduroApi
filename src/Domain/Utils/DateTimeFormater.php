<?php


namespace App\Domain\Utils;


class DateTimeFormater
{
    public static function getPostgresqlDatetimeFormat(?\DateTime $dateTime)
    {
        if ($dateTime) {
            return $dateTime->format('Y-m-d');
        }

        return null;
    }
}

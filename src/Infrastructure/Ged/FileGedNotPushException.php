<?php


namespace App\Infrastructure\Ged;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
final class FileGedNotPushException extends \Exception
{
    public static function createFromPartner(string $code, \Exception $previous = null): self
    {
        return new self(
            sprintf('Document for partner "%s" not push in GED', $code),
            0,
            $previous
        );
    }

    public static function createFromProduct(string $code, \Exception $previous = null): self
    {
        return new self(
            sprintf('Document for product "%s" not push in GED', $code),
            0,
            $previous
        );
    }
}
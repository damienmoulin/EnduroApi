<?php
/**
 * BooleanTransformer.php
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Transformer
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Transformer;

class BooleanTransformer
{
    public static function boolean($input)
    {
        if ('false' === $input) {
            return false;
        }
        if ('true' === $input) {
            return true;
        }

        return $input;
    }
}
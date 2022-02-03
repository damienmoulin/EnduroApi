<?php
/**
 * Interval.php
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Domain\Utils
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Domain\Utils;

class Interval
{
    public ?float $start;
    public ?float $end;

    public function __construct(?float $start, ?float $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
    public function __toString(): string
    {
        return '['.$this->start.', '.$this->end.']';
    }
}
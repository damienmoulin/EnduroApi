<?php
/**
 * DateRange.php.
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Domain\Utils
 *
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Domain\Utils;

class DateRange implements \JsonSerializable
{
    /**
     *
     */
    const INFINITY = 'infinity';
    public ?\DateTime $start;
    public ?\DateTime $end;


    /**
     * @return string
     */
    public function __toString(): string
    {
        $output = '[';
        if (null !== $this->start) {
            $output .= $this->start->format('Y-m-d H:i:s');
        } else {
            $output .= self::INFINITY;
        }
        $output .= ',';

        if (null !== $this->end) {
            $output .= $this->end->format('Y-m-d H:i:s');
        } else {
            $output .= self::INFINITY;
        }
        $output .= ']';

        return $output;
    }


    /**
     * Specify data which should be serialized to JSON.
     *
     * @see https://php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource
     *
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return [
            'start_limit' => $this->start ?? null,
            'end_limit' => $this->end ?? null,
        ];
    }
}

<?php
/**
 * DateTransformer.php
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

/**
 *
 */
class DateTransformer
{
    /**
     * @param $input
     * @return \DateTime|null
     */
    public function toDateTime($input): ?\DateTime
    {
        if(null === $input || 'infinity' === $input){
            return null;
        }

        if($input instanceof \DateTime){
            return $input;
        }

        try{
            return new \DateTime($input);
        }catch (\Exception $exception){
            return new \DateTime();
        }
    }
}
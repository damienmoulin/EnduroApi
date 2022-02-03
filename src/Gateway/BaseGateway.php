<?php
/**
 * BaseGateway.php
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Gateway
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Gateway;

/**
 *
 */
abstract class BaseGateway
{
    const DEFAULT_NB_ELEMENT = 20;
    const DEFAULT_PAGE = 1;

    /**
     * @param array $data
     *
     * @return array
     */
    protected function dataForInsert(array $data): array
    {
        $output = [
            'header' => implode(', ', array_keys($data)),
            'value' => [],
        ];
        $placeholders = [];
        foreach ($data as $item) {
            $placeholders[] = '$*::'.$item['type'];
            $output['value'][] = $item['value'];
        }

        $output['placeholders'] = implode(', ', $placeholders);

        return $output;
    }
    /**
     * @param array $data
     *
     * @return array
     */
    protected function dataForUpdate(array $data): array
    {
        $placeholders = [];
        $values = [];
        foreach ($data as $field => $item) {
            $placeholders[] = $field.' = $*::'.$item['type'];
            $values[] = $item['value'];
        }

        $output  = [
            'placeholders' => implode(', ', $placeholders),
            'value' => $values,
        ];

        return $output;
    }
}
<?php
/**
 * ApiGateway.php
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 * @package App\Gateway\Log
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Gateway\Log;

use App\Gateway\BaseGateway;
use PommProject\Foundation\Pomm;
use PommProject\Foundation\QueryManager\SimpleQueryManager;

class ApiGateway extends BaseGateway
{
    /**
     * @var SimpleQueryManager
     */
    private SimpleQueryManager $queryManager;

    /**
     * @param Pomm               $pomm
     *
     * @throws \PommProject\Foundation\Exception\FoundationException
     */
    public function __construct(
        Pomm $pomm
    ) {
        $this->queryManager = $pomm->getDefaultSession()->getQueryManager();
    }

    /**
     * @param array $data
     * @return null|string
     * @throws \Exception
     */
    public function insert(array $data): ?string
    {
        try {
            $sql = '
INSERT INTO log.api(created_at, route, method, endpoint, header, parameters, request, body, response_code, response, error, ip)
VALUES(
       $*::timestamp without time zone, 
       $*::text, 
       $*::text, 
       $*::text, 
       $*::jsonb, 
       $*::jsonb, 
       $*::jsonb, 
       $*::text, 
       $*::text, 
       $*::jsonb, 
       $*::jsonb, 
       $*::inet
)
RETURNING api_id
;
';

            $result = $this->queryManager->query($sql,array_values($data));

            return $result->get(0)['api_id'];
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

}
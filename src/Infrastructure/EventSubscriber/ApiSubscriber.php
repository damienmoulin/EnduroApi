<?php
/**
 * ApiResponseSubscriber.php.
 *
 * PHP version 7
 *
 * LICENSE: SISMIC
 *
 * @category  CategoryName
 *
 * @author    Laurent BOLZER <lbolzer_at_sismic.fr>
 */

namespace App\Infrastructure\EventSubscriber;

use App\Gateway\Log\ApiGateway;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 *
 */
class ApiSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApiGateway
     */
    private ApiGateway $apiGateway;

    /**
     * @param ApiGateway $apiGateway
     */
    public function __construct(
        ApiGateway $apiGateway
    ) {
        $this->apiGateway = $apiGateway;
    }

    /**
     * @param ControllerEvent $event
     *
     * @return void
     */
    public function onKernelController(ControllerEvent $event)
    {
        $request = $event->getRequest();
        $rawContent = $request->getContent();

        $rawContent = str_replace('__/__/____', null, $rawContent);
        $rawContent = str_replace('__/__/20__', null, $rawContent);

        if ('json' === $request->getContentType() && $rawContent) {
            $data = json_decode($rawContent, true);

            $request->request->replace(is_array($data) ? $data : []);
        }
    }

    /**
     * @param ResponseEvent $event
     * @throws \Exception
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!preg_match('/api/i', $request->getRequestUri())) {
            return;
        }

        $response = $event->getResponse();
        $errors = null;
        if($this->isJson($response->getContent())){
            $content = json_decode($response->getContent(), true);

            if(isset($content['errors'])){
                $errors = $content['errors'];
            }
        }

        $log = [
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            'route' => $request->attributes->get('_route'),
            'method' => $request->getMethod(),
            'endpoint' => $request->getRequestUri(),
            'header' => $request->headers->all(),
            'parameters' => $request->attributes->all(),
            'request' => $request->request->all(),
            'body' => $request->getContent(),
            'response_code' => $response->getStatusCode(),
            'response' => $this->isJson($response->getContent()) ? json_decode($response->getContent()) : null,
            'error' => $errors,
            'ip' => $request->getClientIp(),
        ];

        $this->apiGateway->insert($log);
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    /**
     * @param $string
     *
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);

        return \JSON_ERROR_NONE === json_last_error();
    }
}

<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Serializer\Serializer;

/**
 * Response Transformer
 *
 * @package AdminBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class ResponseTransformerListener
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Kernel Response
     *
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        $response = new Response();

        // Get Request Format
        switch ($request->headers->get('Content-Type')) {
            case 'application/json':
                $requestType = 'json';
                break;
            case 'application/xml':
                $requestType = 'xml';
                break;
            case 'text/xml':
                $requestType = 'xml';
                break;
            default :
                $requestType = "json";
        }

        /**
         * Set Custom Router _format
         */
        if (in_array($request->getRequestFormat(), ['xml', 'json'])) {
            $requestType = $request->getRequestFormat();
        }

        /**
         * Get Controller Result
         */
        $result = $event->getControllerResult();
        if ($result instanceof Response || $result === null) {
            return;
        }

        if ($request->isMethod('POST')) {
            $response->setStatusCode(201);
        }

        /**
         * Serialize Data
         */
        if (!is_scalar($result)) {
            $result = $this->serializer->serialize($result, $requestType);
        }

        /**
         * Set Content
         * Set Header
         */
        $response->setContent($result);
        $response->headers->set('Content-Type', "application/" . $requestType);

        /**
         * Set Response
         */
        $event->setResponse($response);
    }

    /**
     * Default Response Format
     *
     * @return string
     */
    public function defaultFormat()
    {
        return 'json';
    }
}
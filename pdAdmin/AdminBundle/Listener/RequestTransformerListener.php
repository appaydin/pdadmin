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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Serializer\Serializer;

/**
 * Request Transformer
 *
 * @package AdminBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class RequestTransformerListener
{
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Kernel Request Event
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $content = $request->getContent();

        /**
         * Empty
         */
        if (empty($content)) {
            return;
        }

        /**
         * Check Request
         */
        if (!$this->checkRequestType($request)) {
            return;
        }

        /**
         * Transform Data
         */
        if (!$this->transformBody($content, $request)) {
            $response = Response::create('Invalid JSON Request.', 400);
            $event->setResponse($response);
        }
    }

    /**
     * Check JSON Request
     *
     * @param Request $request
     * @return bool
     */
    private function checkRequestType(Request $request)
    {
        return in_array($request->getContentType(), ['xml', 'json']);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function transformBody($content, Request $request)
    {
        $data = $this->serializer->decode($content, $request->getContentType());
        $request->request->replace($data);
        return true;
    }
}
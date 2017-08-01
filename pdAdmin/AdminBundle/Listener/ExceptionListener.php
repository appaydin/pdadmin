<?php

/*
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Listener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * Kernel Exception Listener
 *
 * @package AdminBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class ExceptionListener
{
    protected $container;
    protected $serializer;

    public function __construct(ContainerInterface $container, Serializer $serializer)
    {
        $this->container = $container;
        $this->serializer = $serializer;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        // Customize your response object to display the exception details
        $response = new Response();
        $errors = array();

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
            $errors[] = $exception->getStatusCode() . ': ' . Response::$statusTexts[$exception->getStatusCode()];
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $errors[] = Response::HTTP_INTERNAL_SERVER_ERROR . ': ' . Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];
        }

        /**
         * Developer Mode
         * Tracking Errors
         */
        if ($this->container->getParameter('developer_error_trace') && $this->container->getParameter('developer_mode')) {
            $errors[] = $exception->getMessage();

            $trace = $exception->getTrace()[0];
            if (is_array($trace) && isset($trace['file']) && $trace['line']) {
                $errors[] = $trace['file'] . ': ' . $trace['line'];
            } else {
                $errors[] = $exception->getFile() . ':' . $exception->getLine();
            }
        } else {
            $errors[] = $exception->getMessage();
        }

        // Send the modified response object to the event
        $request = $event->getRequest();
        $format = $this->container->get('pd.utils')->getRequestFormat($request);
        $response->setContent(
            $this->serializer->serialize(['messages' => [
                'error' => $errors
            ]], $format)
        );

        $response->headers->replace(['Content-Type' => 'application/' . $format]);
        $event->setResponse($response);
    }
}
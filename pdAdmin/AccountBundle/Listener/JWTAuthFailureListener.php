<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AccountBundle\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;

/**
 * Authentication Failure Listener
 *
 * @package AccountBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class JWTAuthFailureListener
{
    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        // Response
        $response = $event->getResponse();
        $response->setContent(json_encode([
            'messages' => [ 'error' => [ $response->getStatusCode() . ": Bad credentials, please verify that your username/password are correctly set" ]]
        ]));

        $event->setResponse($response);
    }
}
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

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;

/**
 * Token Not Found
 *
 * @package AccountBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class JWTNotFoundListener
{
    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        // Response
        $response = $event->getResponse();
        $response->setContent(json_encode([
            'auth' => [
                'code' => $response->getStatusCode(),
                'message' => 'Token not found, please log in it.'
            ]
        ]));

        $event->setResponse($response);
    }
}
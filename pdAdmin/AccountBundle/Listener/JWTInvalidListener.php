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

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Token Invalid Listener
 *
 * @package AccountBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class JWTInvalidListener
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        // Response
        $response = $event->getResponse();
        $response->setContent(json_encode([
            'auth' => [
                'code' => $response->getStatusCode(),
                'message' => 'Your token is invalid, please login again to get a new one'
            ],
            'redirect' => $this->router->generate('fos_user_security_login')
        ]));

        $event->setResponse($response);
    }
}
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

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Token Expired Listener
 *
 * @package AccountBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class JWTExpiredListener
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        // Response
        $response = $event->getResponse();
        $response->setContent(json_encode([
            'messages' => [
                $response->getStatusCode() => 'Your token is expired, please renew it.'
            ],
            'redirect' => $this->router->generate('fos_user_security_login')
        ]));

        $event->setResponse($response);
    }
}
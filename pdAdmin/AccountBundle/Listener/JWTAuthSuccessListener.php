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

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class JWTAuthSuccessListener
 *
 * @package AccountBundle\Listener
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class JWTAuthSuccessListener
{
    private $container;
    private $router;

    public function __construct(ContainerInterface $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $profile = $this->container->get('serializer')->normalize($event->getUser(), 'json');

        // Set Login Redirect Data
        $event->setData([
            'profile' => $profile,
            'redirect' => $this->router->generate($this->container->getParameter('user_login_redirect'))
        ]);
    }
}
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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

/**
 * Login Listener
 * @package AccountBundle\Listener
 *
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class LoginListener implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            SecurityEvents::INTERACTIVE_LOGIN => 'onLogin',
        );
    }

    public function onLogin(InteractiveLoginEvent $event)
    {
        // Get User
        $user = $event->getAuthenticationToken()->getUser();

        // Login Set Language
        if ($user->getProfile()->getLanguage()) {
            $event->getRequest()->getSession()->set('_locale', $user->getProfile()->getLanguage());
        }
    }
}
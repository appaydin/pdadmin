<?php

/*
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AccountBundle\Controller;

use FOS\RestBundle\View\View;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class RestRegistrationController
 * @package AccountBundle\Controller
 *
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class RestRegistrationController extends Controller
{
    /**
     * Register Action
     *
     * @param Request $request
     * @return null|\Symfony\Component\Form\FormInterface|JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        // Create Form
        $form = $formFactory->createForm(['csrf_protection' => false]);
        $form->setData($user);

        // Handle Data
        $form->submit($request->request->all());

        if ($form->isSubmitted() && $form->isValid()) {
            // Registration Success Event
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            // Register
            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $response = $this->handleView($this->view([
                    'token' => $this->get('lexik_jwt_authentication.jwt_manager')->create($user),
                    'header' => [
                        'location' => $this->generateUrl('admin_homepage')
                    ]
                ]));
            }

            // Registration Complete Event
            $dispatcher->dispatch(
                FOSUserEvents::REGISTRATION_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }

        // Registration Failure Event
        $event = new FormEvent($form, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

        if (null !== $response = $event->getResponse()) {
            return $response;
        }

        return [
            'data' => $form,
            'view' => $this->renderView('AccountBundle:Default:register.html.php'),
        ];
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $response = $this->redirectToRoute('fos_user_registration_confirmed');
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        // Return
        return $response;
    }

    /**
     * Tell the user his account is now confirmed.
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('@FOSUser/Registration/confirmed.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * Tell the user to check his email provider.
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');

        if (empty($email)) {
            return $this->redirectToRoute('fos_user_registration_register');
        }

        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        // Return
        return $this->handleView(View::create([
            'msg' => 'asdsa'
        ]));

        return $this->render('@FOSUser/Registration/check_email.html.twig', array(
            'user' => $user,
        ));
    }
}

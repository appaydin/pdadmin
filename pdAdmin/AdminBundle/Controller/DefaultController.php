<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $vueView = $this->renderView('AdminBundle:Default:test.html.php');

        return [
            'view' => $vueView
        ];
    }

    public function testAction()
    {
        $profile = $this->getUser();
        //$profile = $this->get('serializer')->serialize($profile, 'json');
        return $profile;
        //return new Response($profile, 200, ['Content-Type' => 'application/json']);
    }
}

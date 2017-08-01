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

use AccountBundle\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RestSecurityController
 * @package AccountBundle\Controller
 *
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class RestSecurityController extends Controller
{
    /**
     * Login Check & Form
     */
    public function loginAction()
    {
        // Create Login Form
        $formData = $this->createForm(LoginForm::class);

        // Show Form
        return [
            'data' => [
                'form' => $this->get('serializer')->normalize($formData)
            ],
            'template' => $this->renderView('AccountBundle:Default:login.html.php'),
            'head' => [
                'title' => [
                    'text' => 'Login'
                ],
                'meta' => [
                    ['name' => 'test', 'content' => 'testx'],
                    ['name' => 'testlogin', 'content' => 'testlogin']
                ]
            ]
        ];
    }

    /**
     * Return User Profile
     *
     * @return mixed
     */
    public function profileAction()
    {
        $user = $this->getUser();
        return $user;
    }
}

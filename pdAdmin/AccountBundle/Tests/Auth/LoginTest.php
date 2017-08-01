<?php

/**
 * This file is part of the pdAdmin package.
 *
 * (c) pdAdmin <http://pdadmin.net/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AccountBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class LoginTest
 * @package AccountBundle\Tests
 *
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class LoginTest extends WebTestCase
{
    public function testLogin()
    {
        $client = $this::createClient();
        $crawler = $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('fos_user_security_login'),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'website',
                'password' => '123123'
            ])
        );

        // Response is OK
        $this->assertTrue(
            $client->getResponse()->isSuccessful(),
            'Status code 2xx is required'
        );

        // Find Token
        $this->assertContains(
            'token',
            $client->getResponse()->getContent(),
            'Token is not found'
        );
    }
}
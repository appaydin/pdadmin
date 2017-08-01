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
 * Class RegisterTest
 * @package AccountBundle\Tests
 *
 * @author  Ramazan Apaydın <iletisim@ramazanapaydin.com>
 */
class RegisterTest extends WebTestCase
{
    public function registerTest()
    {
        $client = $this->createClient();
        $crawler = $client->request(
            'POST',
            $client->getContainer()->get('router')->generate('auth_register'),
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => 'pdtest@pdtest.com',
            ])
        );
    }
}
<?php
namespace App\Tests\Functional\Controller;

use App\Tests\BaseTest;

/**
 * Class LoginControllerTest
 */
class LoginControllerTest extends BaseTest
{
    public function setUp()
    {
        $classes = [
            'App\Tests\DataFixtures\LoadUserData'
        ];
        $this->loadFixtures($classes);
        $this->initClient();
    }

    private function initClient()
    {
        $this->client = static::createClient();
    }

    /**
     * Function: Login
     * Conditions: Success
     */
    public function testLoginSuccess()
    {
        $this->client->request('POST', '/api/v1/login', [], [], [],
            '{
                "username": "natalia",
                "password": "123123"
            }');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('natalia', $response['data']['username']);
    }
}

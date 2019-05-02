<?php
namespace App\Tests\Functional\Controller;

use App\Tests\BaseTest;

class RegisterControllerTest extends BaseTest
{
    /**
     * Function: Register
     * Conditions: Success
     */
    public function testRegisterSuccess()
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/register', [], [], [],
            '{
                "username": "natalia1",
                "password": "123123"
            }');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $response = \json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('natalia1', $response['data']['username']);
    }
}

<?php
namespace App\Tests\Functional\Controller;

use App\Entity\League;
use App\Repository\LeagueRepository;
use App\Tests\BaseTest;
use App\Tests\DataFixtures\LoadUserData;

/**
 * Class CreateLeagueControllerTest
 */
class CreateLeagueControllerTest extends BaseTest
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
     * Function: CreateLeague
     * Conditions: Success
     */
    public function testCreateLeagueSuccess()
    {
        $token = $this->getContainer()->getParameter('jwt_test_key');
        $this->client->request('POST', '/api/v1/league/create',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '. $token],
            '{
                "name": "testLeague"
            }');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('testLeague', $response['data']['name']);
    }
}

<?php
namespace App\Tests\Functional\Controller;

use App\Tests\BaseTest;
use App\Tests\DataFixtures\LoadUserData;

/**
 * Class CreateTeamControllerTest
 */
class CreateTeamControllerTest extends BaseTest
{
    public function setUp()
    {
        $classes = [
            'App\Tests\DataFixtures\LoadUserData',
            'App\Tests\DataFixtures\LoadLeagueData'
        ];
        $this->loadFixtures($classes);
        $this->initClient();
    }

    private function initClient()
    {
        $this->client = static::createClient();
    }

    /**
     * Function: CreateTeam
     * Conditions: Success
     */
    public function testCreateTeamSuccess()
    {
        $token = $this->getContainer()->getParameter('jwt_test_key');
        $this->client->request('POST', '/api/v1/league/1/team/create',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '. $token],
            '{
                "name": "tests2",
                "strip": "trtsd2"
            }');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('tests2', $response['data']['name']);
        $this->assertEquals('trtsd2', $response['data']['strip']);
    }
}

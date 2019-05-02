<?php
namespace App\Tests\Functional\Controller;

use App\Tests\BaseTest;
use App\Tests\DataFixtures\LoadUserData;

/**
 * Class GetTeamsInLeagueControllerTest
 */
class GetTeamsInLeagueControllerTest extends BaseTest
{
    public function setUp()
    {
        $classes = [
            'App\Tests\DataFixtures\LoadUserData',
            'App\Tests\DataFixtures\LoadTeamData'
        ];
        $this->loadFixtures($classes);
        $this->initClient();
    }

    private function initClient()
    {
        $this->client = static::createClient();
    }

    /**
     * Function: TeamGets
     * Conditions: Success
     */
    public function testTeamGetsSuccess()
    {
        $token = $this->getContainer()->getParameter('jwt_test_key');
        $this->client->request('GET', '/api/v1/league/1/teams',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '. $token]
            );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $response = \json_decode($this->client->getResponse()->getContent(), true);
        $this->assertCount(2, $response['data']);
    }
}

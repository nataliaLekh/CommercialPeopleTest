<?php
namespace App\Tests\Functional\Controller;

use App\Entity\Team;
use App\Repository\TeamRepository;
use App\Tests\BaseTest;
use App\Tests\DataFixtures\LoadUserData;

/**
 * Class UpdateTeamControllerTest
 */
class UpdateTeamControllerTest extends BaseTest
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
     * Function: TeamUpdate
     * Conditions: Success
     */
    public function testTeamUpdateSuccess()
    {
        $token = $this->getContainer()->getParameter('jwt_test_key');
        $this->client->request('POST', '/api/v1/league/1/team/1/update',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '. $token],
            '{
                "name": "edited",
                "strip": "edited"
            }');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        /** @var TeamRepository $teamRepository */
        $teamRepository = $this->getService('App\Repository\TeamRepository');

        /** @var Team $team */
        $team = $teamRepository->find(1);
        $this->assertEquals('edited', $team->name());
        $this->assertEquals('edited', $team->strip());
    }
}

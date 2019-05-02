<?php
namespace App\Tests\Functional\Controller;

use App\Repository\LeagueRepository;
use App\Tests\BaseTest;
use App\Tests\DataFixtures\LoadUserData;

/**
 * Class DeleteLeagueControllerTest
 */
class DeleteLeagueControllerTest extends BaseTest
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
     * Function: DeleteLeague
     * Conditions: Success
     */
    public function testDeleteLeagueSuccess()
    {
        /** @var LeagueRepository $leagueRepository */
        $leagueRepository = $this->getService('App\Repository\LeagueRepository');
        $this->assertNotNull($leagueRepository->find(1));

        $token = $this->getContainer()->getParameter('jwt_test_key');
        $this->client->request('POST', '/api/v1/league/1/delete',
            [],
            [],
            ['HTTP_Authorization' => 'Bearer '. $token]
            );

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertNull($leagueRepository->find(1));
    }
}

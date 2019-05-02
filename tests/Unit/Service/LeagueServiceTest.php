<?php
namespace App\Tests\Unit\Service;

use App\Entity\League;
use App\Entity\Team;
use App\Exception\LeagueNotExistException;
use App\Repository\LeagueRepository;
use App\Service\LeagueService;
use App\Tests\BaseTest;

/**
 * Class LeagueServiceTest
 */
class LeagueServiceTest extends BaseTest
{
    public function setUp()
    {
        parent::setUp();
        $this->mockAllInjections();
    }

    /**
     * Mock all service in tested class.
     */
    public function mockAllInjections()
    {
        $this->injectServiceMock(LeagueRepository::class);
    }

    /**
     * Function: CreateLeague
     * Conditions: Success
     */
    public function testCreateLeagueSuccess()
    {
        /** @var LeagueService $leagueService */
        $leagueService = $this->getService(LeagueService::class);

        $league = $leagueService->createLeague('test');
        $this->assertEquals($league['name'], 'test');
    }

    /**
     * Function: getTeams
     * Conditions: Success
     */
    public function testGetTeamsSuccess()
    {
        $league = new League('test');
        $team1 = new Team('team 1', 'test', $league);
        $team2 = new Team('team 2', 'test', $league);

        $league->addTeam($team1);
        $league->addTeam($team2);

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn($league);

        /** @var LeagueService $leagueService */
        $leagueService = $this->getService(LeagueService::class);
        $teams = $leagueService->getTeams(1);
        $this->assertEquals(2, \count($teams));
    }

    /**
     * Function: getTeams
     * Conditions: Error
     */
    public function testGetTeamsLeagueNotFound()
    {
        $this->expectException(LeagueNotExistException::class);
        $message = LeagueNotExistException::INTERNAL_MESSAGE;
        $this->expectExceptionMessage($message);

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn(null);

        /** @var LeagueService $leagueService */
        $leagueService = $this->getService(LeagueService::class);
        $leagueService->getTeams(1);
    }

    /**
     * Function: getTeams
     * Conditions: Success
     */
    public function testDeleteLeagueSuccess()
    {
        $league = new League('test');

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn($league);

        /** @var LeagueService $leagueService */
        $leagueService = $this->getService(LeagueService::class);
        $leagueService->deleteLeague(1);
        $this->assertNull(null);
    }
}

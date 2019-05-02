<?php
namespace App\Tests\Unit\Service;

use App\Entity\League;
use App\Entity\Team;
use App\Exception\LeagueNotExistException;
use App\Exception\TeamNotExistException;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use App\Service\TeamService;
use App\Tests\BaseTest;

/**
 * Class TeamServiceTest
 */
class TeamServiceTest extends BaseTest
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
        $this->injectServiceMock(TeamRepository::class);
        $this->injectServiceMock(LeagueRepository::class);
    }

    /**
     * Function: CreateTeam
     * Conditions: Success
     */
    public function testCreateTeamSuccess()
    {
        $league = new League('test');

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn($league);
        $leagueRepository->method('save')->willReturn(true);

        /** @var TeamService $teamService */
        $teamService = $this->getService(TeamService::class);
        $team = $teamService->createTeam(1, 'test', 'test');

        $this->assertEquals($team['name'], 'test');
        $this->assertEquals($team['strip'], 'test');
    }

    /**
     * Function: createTeam
     * Conditions: Error
     */
    public function testCreateTeamLeagueNotFound()
    {
        $this->expectException(LeagueNotExistException::class);
        $message = LeagueNotExistException::INTERNAL_MESSAGE;
        $this->expectExceptionMessage($message);

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn(null);

        /** @var TeamService $teamService */
        $teamService = $this->getService(TeamService::class);
        $teamService->createTeam(1, 'test', 'test');
    }

    /**
     * Function: UpdateTeam
     * Conditions: Success
     */
    public function testUpdateTeamSuccess()
    {
        $league = new League('test');
        $team = new Team('team 1', 'test', $league);

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn($league);

        /** @var \PHPUnit_Framework_MockObject_MockObject $teamRepository */
        $teamRepository = $this->getService(TeamRepository::class);
        $teamRepository->method('find')->willReturn($team);
        $teamRepository->method('save')->willReturn(true);

        /** @var TeamService $teamService */
        $teamService = $this->getService(TeamService::class);
        $teamService->updateTeam(1, 'edited', 'edited', 3);

        $this->assertEquals($team->name(), 'edited');
        $this->assertEquals($team->strip(), 'edited');
    }

    /**
     * Function: UpdateTeam
     * Conditions: Уккщк
     */
    public function testUpdateTeamNotFound()
    {
        $this->expectException(TeamNotExistException::class);
        $message = TeamNotExistException::INTERNAL_MESSAGE;
        $this->expectExceptionMessage($message);

        /** @var \PHPUnit_Framework_MockObject_MockObject $teamRepository */
        $teamRepository = $this->getService(TeamRepository::class);
        $teamRepository->method('find')->willReturn(null);

        /** @var TeamService $teamService */
        $teamService = $this->getService(TeamService::class);
        $teamService->updateTeam(1, 'edited', 'edited', 3);
    }

    /**
     * Function: UpdateTeam
     * Conditions: Уккщк
     */
    public function testUpdateLeagueNotFound()
    {
        $this->expectException(LeagueNotExistException::class);
        $message = LeagueNotExistException::INTERNAL_MESSAGE;
        $this->expectExceptionMessage($message);

        $team = new Team('team 1', 'test', new League('test'));

        /** @var \PHPUnit_Framework_MockObject_MockObject $leagueRepository */
        $leagueRepository = $this->getService(LeagueRepository::class);
        $leagueRepository->method('find')->willReturn(null);

        /** @var \PHPUnit_Framework_MockObject_MockObject $teamRepository */
        $teamRepository = $this->getService(TeamRepository::class);
        $teamRepository->method('find')->willReturn($team);

        /** @var TeamService $teamService */
        $teamService = $this->getService(TeamService::class);
        $teamService->updateTeam(1, 'edited', 'edited', 3);
    }
}

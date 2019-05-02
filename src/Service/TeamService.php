<?php
namespace App\Service;

use App\Entity\League;
use App\Entity\Team;
use App\Exception\LeagueNotExistException;
use App\Exception\TeamNotExistException;
use App\Repository\LeagueRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class TeamService
 */
class TeamService
{
    /**
     * @var TeamRepository
     */
    private $teamRepository;

    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * TeamService constructor.
     *
     * @param TeamRepository $teamRepository
     * @param LeagueRepository $leagueRepository
     */
    public function __construct(TeamRepository $teamRepository, LeagueRepository $leagueRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param int $leagueId
     * @param string $name
     * @param string $strip
     *
     * @throws ORMException
     * @throws LeagueNotExistException
     * @throws OptimisticLockException
     *
     * @return array
     */
    public function createTeam(int $leagueId, string $name, string $strip): array
    {
        /** @var League $league */
        $league = $this->leagueRepository->find($leagueId);
        if (!$league) {
           throw new LeagueNotExistException();
        }

        $team = new Team($name, $strip, $league);
        $league->addTeam($team);

        $this->leagueRepository->save($league);

        return $team->prepareResponse();
    }

    /**
     * @param int $teamId
     * @param string $name
     * @param string $strip
     * @param int|null $leagueId
     *
     * @throws ORMException
     * @throws TeamNotExistException
     * @throws LeagueNotExistException
     * @throws OptimisticLockException
     */
    public function updateTeam(int $teamId, string $name, string $strip, int $leagueId = null): void
    {
        /** @var Team $team */
        $team = $this->teamRepository->find($teamId);
        if (!$team) {
            throw new TeamNotExistException();
        }

        if ($leagueId) {
            /** @var League $league */
            $league = $this->leagueRepository->find($leagueId);
            if (!$league) {
                throw new LeagueNotExistException();
            }
            $team->updateLeague($league);
        }

        $team->rename($name);
        $team->changeStrip($strip);

        $this->teamRepository->save($team);
    }
}

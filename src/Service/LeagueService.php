<?php
namespace App\Service;

use App\Entity\League;
use App\Entity\Team;
use App\Exception\LeagueNotExistException;
use App\Repository\LeagueRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class LeagueService
 */
class LeagueService
{
    /**
     * @var LeagueRepository
     */
    private $leagueRepository;

    /**
     * LeagueService constructor.
     *
     * @param LeagueRepository $leagueRepository
     */
    public function __construct(LeagueRepository $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param string $name
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @return array
     */
    public function createLeague(string $name): array
    {
        $league = new League($name);
        $this->leagueRepository->save($league);

        return $league->prepareResponse();
    }

    /**
     * @param int $leagueId
     *
     * @throws LeagueNotExistException
     *
     * @return array
     */
    public function getTeams(int $leagueId): array
    {
        /** @var League $league */
        $league = $this->leagueRepository->find($leagueId);
        if (!$league) {
            throw new LeagueNotExistException();
        }

        $teams = $league->getTeams();
        /** @var Team $team */
        foreach ($teams as $team) {
            $result[] = $team->prepareResponse();
        }

        return $result ?? [];
    }

    /**
     * @param int $leagueId
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function deleteLeague(int $leagueId): void
    {
        /** @var League $league */
        $league = $this->leagueRepository->find($leagueId);
        $this->leagueRepository->remove($league);
    }
}

<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\LeagueNotExistException;
use App\Helper\ResponseHelper;
use App\Service\LeagueService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetTeamsInLeagueController
 *
 * @Route("/league/{leagueId}/teams", name="league_list_team_1_0", methods={"GET"})
 */
class GetTeamsInLeagueController extends BaseController
{
    /**
     * Get team list in league
     *
     * @param int $leagueId
     * @param LeagueService $leagueService
     *
     * @return JsonResponse
     * @throws LeagueNotExistException
     */
    public function __invoke(int $leagueId, LeagueService $leagueService): JsonResponse
    {
        $teams = $leagueService->getTeams($leagueId);

        return ResponseHelper::successJsonResponse($teams);
    }
}

<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\InternalServerException;
use App\Exception\LeagueNotExistException;
use App\Exception\TeamNotExistException;
use App\Helper\ResponseHelper;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TeamService;

/**
 * Class UpdateTeamController
 *
 * @Route("/league/{leagueId}/team/{teamId}/update", name="team_update_1_0", methods={"POST"})
 */
class UpdateTeamController extends BaseController
{
    /**
     * Update team
     *
     * @param int $leagueId
     * @param int $teamId
     * @param Request $request
     * @param TeamService $teamService
     *
     * @return JsonResponse
     *
     * @throws InternalServerException
     * @throws ORMException
     * @throws LeagueNotExistException
     * @throws TeamNotExistException
     * @throws OptimisticLockException
     */
    public function __invoke(int $leagueId, int $teamId, Request $request, TeamService $teamService): JsonResponse
    {
        $parameters = $this->getParameterBag($request);
        $teamService->updateTeam(
            $teamId,
            $parameters->get('name'),
            $parameters->get('strip'),
            $parameters->get('newLeagueId', null)
        );

        return ResponseHelper::successJsonResponse([]);
    }
}

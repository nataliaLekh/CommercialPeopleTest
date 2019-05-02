<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\InternalServerException;
use App\Exception\LeagueNotExistException;
use App\Helper\ResponseHelper;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TeamService;

/**
 * Class CreateTeamController
 *
 * @Route("/league/{leagueId}/team/create", name="team_create_1_0", methods={"POST"})
 */
class CreateTeamController extends BaseController
{
    /**
     * Create team
     *
     * @param int $leagueId
     * @param Request $request
     * @param TeamService $teamService
     *
     * @return JsonResponse
     * @throws InternalServerException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws LeagueNotExistException
     */
    public function __invoke(int $leagueId, Request $request, TeamService $teamService): JsonResponse
    {
        $parameters = $this->getParameterBag($request);

        $team = $teamService->createTeam($leagueId, $parameters->get('name'), $parameters->get('strip'));

        return ResponseHelper::successJsonResponse($team);
    }
}

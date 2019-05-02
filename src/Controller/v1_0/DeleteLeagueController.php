<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\InternalServerException;
use App\Exception\LeagueNotExistException;
use App\Helper\ResponseHelper;
use App\Service\LeagueService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteLeagueController
 *
 * @Route("/league/{leagueId}/delete", name="league_delete_1_0", methods={"POST"})
 */
class DeleteLeagueController extends BaseController
{
    /**
     * Delete league
     *
     * @param int $leagueId
     * @param LeagueService $LeagueService
     *
     * @return JsonResponse
     * @throws InternalServerException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws LeagueNotExistException
     */
    public function __invoke(int $leagueId, LeagueService $LeagueService): JsonResponse
    {
        $LeagueService->deleteLeague($leagueId);

        return ResponseHelper::successJsonResponse([]);
    }
}

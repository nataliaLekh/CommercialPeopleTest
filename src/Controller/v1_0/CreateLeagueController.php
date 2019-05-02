<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\InternalServerException;
use App\Helper\ResponseHelper;
use App\Service\LeagueService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateLeagueController
 *
 * @Route("/league/create", name="league_create_1_0", methods={"POST"})
 */
class CreateLeagueController extends BaseController
{
    /**
     * Create league
     *
     * @param Request $request
     * @param LeagueService $leagueService
     *
     * @return JsonResponse
     *
     * @throws InternalServerException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, LeagueService $leagueService): JsonResponse
    {
        $parameters = $this->getParameterBag($request);
        $league = $leagueService->createLeague($parameters->get('name'));

        return ResponseHelper::successJsonResponse($league);
    }
}

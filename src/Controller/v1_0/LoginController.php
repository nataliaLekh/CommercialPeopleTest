<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\InternalServerException;
use App\Helper\ResponseHelper;
use App\Service\UserService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 *
 * @Route("/login", name="login_1_0", methods={"POST"})
 */
class LoginController extends BaseController
{
    /**
     * Login
     *
     * @param Request $request
     * @param UserService $userService
     *
     * @return JsonResponse
     * @throws InternalServerException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, UserService $userService): JsonResponse
    {
        $parameters = $this->getParameterBag($request);
        $user = $userService->login($parameters->get('username'), $parameters->get('password'));

        return ResponseHelper::successJsonResponse($user);
    }
}

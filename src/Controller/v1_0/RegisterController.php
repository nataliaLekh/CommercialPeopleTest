<?php
namespace App\Controller\v1_0;

use App\Controller\BaseController;
use App\Exception\InternalServerException;
use App\Helper\ResponseHelper;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegisterController
 *
 * @Route("/register", name="register_1_0", methods={"POST"})
 */
class RegisterController extends BaseController
{
    /**
     * Login
     *
     * @param Request $request
     * @param UserService $userService
     *
     * @return JsonResponse
     * @throws InternalServerException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __invoke(Request $request, UserService $userService): JsonResponse
    {
        $parameters = $this->getParameterBag($request);
        $user = $userService->register($parameters->get('username'), $parameters->get('password'));

        return ResponseHelper::successJsonResponse($user);
    }
}

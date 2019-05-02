<?php
namespace App\Controller;

use App\Exception\InternalServerException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Class BaseController
 */
class BaseController extends AbstractController
{
    /**
     * Get parameters by request.
     *
     * @param Request $request
     * @param bool $canBeEmpty
     *
     * @return ParameterBag
     *
     * @throws InternalServerException
     */
    protected function getParameterBag(Request $request, $canBeEmpty = false): ParameterBag
    {
        $parameters = new ParameterBag(\json_decode($request->getContent(), true) ?: ($canBeEmpty ? [] : false));
        if (!$canBeEmpty && $parameters == false) {
            throw new InternalServerException();
        }

        return $parameters;
    }
}

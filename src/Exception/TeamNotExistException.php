<?php
namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TeamNotExistException
 */
class TeamNotExistException extends TeamException
{
    const CODE = 'team_not_exist_error';
    const STATUS_CODE = JsonResponse::HTTP_NOT_FOUND;
    const INTERNAL_MESSAGE = 'Team not exist.';

    /**
     * TeamNotExistException constructor.
     *
     * @param null $previous
     */
    public function __construct($previous = null)
    {
        parent::__construct(self::INTERNAL_MESSAGE, self::STATUS_CODE, self::CODE, $previous);
    }
}

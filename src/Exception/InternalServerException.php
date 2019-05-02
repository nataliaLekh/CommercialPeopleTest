<?php
namespace App\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;

class InternalServerException extends TeamException
{
    const CODE = 'internal_error';
    const STATUS_CODE = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
    const INTERNAL_MESSAGE = 'Sorry but something wrong.';

    /**
     * InternalServerException constructor.
     *
     * @param null $previous
     * @param null|string $message
     */
    public function __construct(string $message = null, $previous = null)
    {
        parent::__construct($message ?? self::INTERNAL_MESSAGE, self::STATUS_CODE, self::CODE, $previous);
    }
}

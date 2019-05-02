<?php
namespace App\Helper;

use App\Exception\InternalServerException;
use App\Exception\TeamException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ResponseHelper
 */
class ResponseHelper
{
    /**
     * Return JSON response with exception data.
     *
     * @param TeamException|null $exception
     *
     * @return JsonResponse
     */
    public static function errorJsonResponse(TeamException $exception = null): JsonResponse
    {
        if ($exception === null) {
            $exception = new InternalServerException();
        }

        $result = new JsonResponse();
        $errorData = [
            'error' => [
                'code' => $exception->getInternalCode(),
                'message' => $exception->getMessage()
            ]
        ];

        $result->setData($errorData);
        $result->setStatusCode($exception->getCode());

        return $result;
    }

    /**
     * Return successful JSON response with data.
     *
     * @param array|null $data
     *
     * @return JsonResponse
     */
    public static function successJsonResponse(array $data = null): JsonResponse
    {
        $result = new JsonResponse();
        $result->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        if ($data !== null) {
            $response = [
                'data' => $data
            ];

            $result->setData($response);
        }

        return $result;
    }
}

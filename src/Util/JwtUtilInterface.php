<?php
namespace App\Util;

use stdClass;

/**
 * Interface JwtUtilInterface
 */
interface JwtUtilInterface
{
    /**
     * @param iterable $tokenData
     *
     * @return string
     */
    public function encode(iterable $tokenData): string;

    /**
     * @param string $tokenString
     *
     * @return stdClass
     */
    public function decode(string $tokenString): stdClass;
}
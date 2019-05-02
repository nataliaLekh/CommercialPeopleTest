<?php
namespace App\Exception;

use Exception;
use Throwable;

/**
 * Class TeamException
 */
abstract class TeamException extends Exception
{
    /**
     * @var string
     */
    protected $internalCode;

    /**
     * TeamException constructor.
     *
     * @param string $message
     * @param int $code
     * @param string $internalCode
     *
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        string $internalCode = InternalServerException::CODE,
        Throwable $previous = null
    ) {
        $this->setInternalCode($internalCode);
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getInternalCode(): string
    {
        return $this->internalCode;
    }

    /**
     * @param string $internalCode
     */
    public function setInternalCode(string $internalCode)
    {
        $this->internalCode = $internalCode;
    }
}

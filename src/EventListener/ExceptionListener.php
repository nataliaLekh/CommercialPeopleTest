<?php
namespace App\EventListener;

use App\Exception\InternalServerException;
use App\Exception\TeamException;
use App\Helper\ResponseHelper;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 */
class ExceptionListener
{
    /**
     * @var string
     */
    private $env;

    /**
     * @param string $env
     */
    public function __construct(string $env)
    {
        $this->env = $env;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $errMessage = $exception->getMessage();
        if ($this->env !== 'prod') {
            $errMessage .= ';/n File: ' . $exception->getFile()
                . ';/n Line:' . $exception->getLine()
                . ';/n Trace: ' . $exception->getTraceAsString();
        }
        if (!$exception instanceof TeamException) {
            $exception = new InternalServerException($errMessage, $exception);
        }

        $response = ResponseHelper::errorJsonResponse($exception);
        $event->setResponse($response);
    }
}

<?php

namespace Reliv\PipeRat\Middleware\Error;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\ErrorMiddlewareInterface;

/**
 * Class TriggerErrorHandler
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class TriggerErrorHandler implements ErrorMiddlewareInterface
{
    /**
     * Process an incoming error, along with associated request and response.
     *
     * Accepts an error, a server-side request, and a response instance, and
     * does something with them; if further processing can be done, it can
     * delegate to `$next`.
     *
     * @see MiddlewareInterface
     *
     * @param mixed         $error
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return void
     * @throws \Throwable
     * @throws mixed
     */
    public function __invoke($error, Request $request, Response $response, callable $next = null)
    {
//        if($error instanceof \Throwable) {
//            throw $error;
//        }

        //Insure the error shows up in the php error.log
        trigger_error($error, E_USER_ERROR);
        //Execution does NOT proceed past this line.
    }
}

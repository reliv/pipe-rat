<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\RouteException;

/**
 * Class OperationMiddleware
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class OperationMiddleware extends AbstractOperationMiddleware implements Middleware
{
    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $out
     *
     * @return mixed
     * @throws RouteException
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $out = null
    ) {
        $routeMiddlewareProvider = $this->getRouteMiddlewareProvider();
        $errorMiddlewareProvider = $this->getErrorMiddlewareProvider();
        $middlewareProvider = $this->getMiddlewareProvider();

        // ROUTE
        $routePipe = new MiddlewarePipe();

        $request = $routeMiddlewareProvider->buildPipe(
            $routePipe,
            $request
        );

        $mainPipe = new MiddlewarePipe();

        $request = $middlewareProvider->buildPipe(
            $mainPipe,
            $request
        );

        $routePipe->pipe($mainPipe);

        $request = $errorMiddlewareProvider->buildPipe(
            $routePipe,
            $request
        );

        $result = $routePipe(
            $request,
            $response,
            $out
        );

        return $result;
    }
}

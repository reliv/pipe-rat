<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\RouteException;
use Reliv\PipeRat\RequestAttribute\ResourceKey;

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

        // ROUTE
        $routePipe = new MiddlewarePipe();

        $request = $routeMiddlewareProvider->buildPipe(
            $routePipe,
            $request
        );

        $routePipe->pipe([$this, 'mainPipe']);

        $request = $errorMiddlewareProvider->buildPipe(
            $routePipe,
            $request
        );

        return $routePipe(
            $request,
            $response,
            $out
        );
    }

    /**
     * mainPipe
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $out
     *
     * @return mixed
     */
    public function mainPipe(
        Request $request,
        Response $response,
        callable $out = null
    ) {
        if (empty($request->getAttribute(ResourceKey::getName()))) {
            return $out($request, $response);
        }

        $middlewareProvider = $this->getMiddlewareProvider();

        $mainPipe = new MiddlewarePipe();

        $request = $middlewareProvider->buildPipe(
            $mainPipe,
            $request
        );

        return $mainPipe($request,$response, $out);
    }
}

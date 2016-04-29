<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\RouteException;
use Reliv\PipeRat\Middleware\Error\ErrorHandler;
use Reliv\PipeRat\ServiceModel\ControllerModel;
use Reliv\PipeRat\ServiceModel\ServiceModelCollection;

/**
 * Class MainMiddleware
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class MainMiddleware extends AbstractModelMiddleware implements Middleware
{
    /**
     * __invoke
     *
     * @param Request $request
     * @param Response $response
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
        $routeModel = $this->getRouteModel($request);
        $errorModel = $this->getErrorModel();

        // ROUTE
        $routePipe = new MiddlewarePipe();

        $routePipe->pipeServices($routeModel);
        $routePipe->pipe([$this, 'postRoute']);
        $routePipe->pipeServices($errorModel);

        $result = $routePipe(
            $request,
            $response,
            $out
        );

        return $result;
    }

    /**
     * postRoute
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $out
     *
     * @return mixed
     */
    public function postRoute(
        Request $request,
        Response $response,
        callable $out = null
    ) {
        if (empty($this->getResourceKey($request))
            || empty($this->getMethodKey($request))
        ) {
            return $out($request, $response);
        }

        $resourceModel = $this->getResourceModel($request);
        $methodModel = $this->getMethodModel($request);

        /** @var ControllerModel $controllerModel */
        $controllerModel = $resourceModel->getControllerModel();
        $controllerOptions = $controllerModel->getOptions();
        $controllerService = $controllerModel->getService();

        if (empty($controllerService)) {
            return $out($request, $response);
        }

        $middlewarePipe = new MiddlewarePipe();

        /** @var ServiceModelCollection $resourcePreServiceModel */
        $resourcePreServiceModel = $resourceModel->getPreServiceModel();
        $middlewarePipe->pipeServices($resourcePreServiceModel);

        /** @var ServiceModelCollection $resourceMethodPreServiceModel */
        $methodPreServiceModel = $methodModel->getPreServiceModel();
        $middlewarePipe->pipeServices($methodPreServiceModel);

        // run method(Request $request, Response $response);
        $method = $methodModel->getName();

        $request = $request->withAttribute(
            OptionsMiddleware::REQUEST_ATTRIBUTE_OPTIONS,
            $controllerOptions
        );

        $middlewareOptions = new OptionsMiddleware($controllerOptions);
        $middlewarePipe->pipe($middlewareOptions);
        $middlewarePipe->pipe([$controllerService, $method]);

        /** @var ServiceModelCollection $resourceMethodPostServiceModel */
        $methodPostServiceModel = $methodModel->getPostServiceModel();
        $middlewarePipe->pipeServices($methodPostServiceModel);

        /** @var ServiceModelCollection $resourcePostServiceModel */
        $resourcePostServiceModel = $resourceModel->getPostServiceModel();
        $middlewarePipe->pipeServices($resourcePostServiceModel);

        return $middlewarePipe($request, $response, $out);
    }
}

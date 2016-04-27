<?php

namespace Reliv\PipeRat\Middleware\Router;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\RouteException;
use Reliv\PipeRat\Middleware\AbstractModelMiddleware;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\ServiceModel\MethodModel;
use Reliv\PipeRat\ServiceModel\ResourceModel;
use Reliv\PipeRat\ServiceModel\RouteModel;

/**
 * Class CurlyBraceVarRouter This is a router that allows paths like /fun/{id}
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\Middleware
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CurlyBraceVarRouter extends AbstractModelMiddleware implements Middleware
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

        //It is every router's job to add the RouteModel attribute to the request
        /** @var Request $request */
        $request = $request->withAttribute(
            RouteModel::REQUEST_ATTRIBUTE_MODEL_ROUTE,
            $routeModel
        );

        $uriParts = explode('/', $request->getUri()->getPath());

        //Cut off the first /
        array_shift($uriParts);

        if (count($uriParts) == 0 || empty($uriParts[0])) {
            //Route is not for us so leave
            return $out($request, $response);
        }

        $resourceKey = $uriParts[0];

        $request = $request->withAttribute(
            self::REQUEST_ATTRIBUTE_RESOURCE_KEY,
            $resourceKey
        );

        //Cut the resource key off the path. We don't need it anymore
        array_shift($uriParts);
        $uri = implode('/', $uriParts);

        /** @var ResourceModel $resourceModel */
        $resourceModel = $this->getResourceModel($request);

        /** @var MethodModel $methodModel */
        $methodModel = null;

        $availableMethods = $resourceModel->getAvailableMethodModels();

        $aPathMatched = false;

        /** @var MethodModel $availableMethod */
        foreach ($availableMethods as $availableMethod) {
            /** @var RouteModel $routeModel */
            $routeModel = $request->getAttribute(RouteModel::REQUEST_ATTRIBUTE_MODEL_ROUTE);

            $path = $availableMethod->getPath();
            $httpVerb = $availableMethod->getHttpVerb();

            $regex = '/^' . str_replace(['{', '}', '/'], ['(?<', '>[^/]+)', '\/'], $path) . '$/';


            $pathMatched = preg_match($regex, $uri, $captures);

            if ($pathMatched) {
                $aPathMatched = true;
            }

            if (!(empty($httpVerb) || $request->getMethod() === $httpVerb)
                || !$pathMatched
            ) {//Route did not match, try next one.
                continue;
            }

            $methodModel = $availableMethod;

            //Put the route params in the request
            foreach ($captures as $key => $val) {
                if (!is_numeric($key)) {
                    $routeModel->setRouteParam($key, $val);
                }
            }

            break;
        }

        if (empty($methodModel)) {
            if ($aPathMatched) {
                //If a Path matched but an http verb did not, return 405 Method not allowed
                return $response->withStatus(405);
            }

            //Route is not for us so leave
            return $out($request, $response);
        }

        $request = $request->withAttribute(
            self::REQUEST_ATTRIBUTE_RESOURCE_METHOD_KEY,
            $methodModel->getName()
        );

        return $out($request, $response);
    }
}

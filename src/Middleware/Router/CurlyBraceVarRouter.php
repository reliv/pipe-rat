<?php

namespace Reliv\PipeRat\Middleware\Router;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ConfigException;
use Reliv\PipeRat\Exception\RouteException;
use Reliv\PipeRat\Middleware\AbstractModelMiddleware;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\RequestAttribute\Paths;
use Reliv\PipeRat\RequestAttribute\ResourceKey;
use Reliv\PipeRat\RequestAttribute\RouteParams;
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
        $aPathMatched = false;

        /** @var MethodModel $availablePath */
        foreach ($request->getAttribute(Paths::ATTRIBUTE_NAME) as $availablePath => $availableVerbs) {
            $regex = '/^' . str_replace(['{', '}', '/'], ['(?<', '>[^/]+)', '\/'], $availablePath) . '$/';
            if (preg_match($regex, $request->getUri(), $captures)) {
                $aPathMatched = true;

                foreach ($availableVerbs as $availableVerb => $routeData) {
                    if (strcasecmp($availableVerb, $request->getMethod())) {
                        //Put the route params in the request
                        $routeParams = [];
                        foreach ($captures as $key => $val) {
                            if (!is_numeric($key)) {
                                $routeParams[$key] = $val;
                            }
                        }

                        return $out(
                            $request->withAttribute(ResourceKey::ATTRIBUTE_NAME, $routeData)
                                ->withAttribute(RouteParams::ATTRIBUTE_NAME, new RouteParams($routeParams)),
                            $response
                        );
                    }
                }
                break;
            }
        }

        if ($aPathMatched) {
            //If a Path matched but an http verb did not, return 405 Method not allowed
            return $response->withStatus(405);
        }

        //Route is not for us so leave
        return $out($request, $response);
    }
}

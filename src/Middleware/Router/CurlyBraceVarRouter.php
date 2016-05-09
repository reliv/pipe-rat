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
     * Our job as a pipe rat router is to set the "ResourceKey" route param to the
     * data that we are given for the matched route.
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
                        return $out(
                            $request->withAttribute(
                                ResourceKey::ATTRIBUTE_NAME,
                                $routeData
                            )->withAttribute(
                                RouteParams::ATTRIBUTE_NAME,
                                new RouteParams($this->parseNamedCaptures($captures))
                            ),
                            $response
                        );
                    }
                }
                break;
            }
        }

        if ($aPathMatched) {
            //A path matched but a verb did not so return "Method not allowed"
            return $response->withStatus(405);
        }

        //No paths matched so do nothing and allow other middleware to handle this request.
        return $out($request, $response);
    }

    /**
     * Filters the junk numerically keyed captures out of a preg_match captures array
     * leaving us with only the juicy named captures.
     *
     * @param $captures
     * @return array
     */
    protected function parseNamedCaptures($captures)
    {
        $filteredCaptures = [];
        foreach ($captures as $key => $val) {
            if (!is_numeric($key)) {
                $filteredCaptures[$key] = $val;
            }
        }

        return $filteredCaptures;
    }
}

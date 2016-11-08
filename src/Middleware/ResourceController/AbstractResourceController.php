<?php

namespace Reliv\PipeRat\Middleware\ResourceController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Exception\MethodException;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Options\BasicOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\RouteParams;

/**
 * Class AbstractResourceController
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class AbstractResourceController extends AbstractMiddleware
{
    /**
     * __invoke
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $out
     *
     * @return mixed
     * @throws MethodException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $method = $this->getOption($request, 'method', null);

        // method option not defined
        if ($method === null) {
            throw new MethodException('Method options not defined');
        }

        if (!method_exists($this, $method)) {
            throw new MethodException('Method does not exists: ' . $method);
        }

        return $this->$method($request, $response, $out);
    }

    /**
     * getUrlParam
     *
     * @param Request $request
     * @param string $key
     * @param null $default
     *
     * @return null
     */
    protected function getRouteParam(Request $request, $key, $default = null)
    {
        /** @var Options $routeParams */
        $routeParams = $request->getAttribute(
            RouteParams::getName(),
            new BasicOptions()
        );

        return $routeParams->get($key, $default);
    }

    /**
     * Get the where param form the URL.
     *
     * Looks like:{"country":"CAN"} or {"country":{"name":"United States"}}
     *
     * @param Request $request
     *
     * @return array|mixed
     * @throws InvalidWhereException
     */
    public function getWhere(Request $request)
    {
        return $request->getAttribute('whereFilterParam', []);
    }

    /**
     * Get the order param from the url to find out how the response
     * should be ordered.
     *
     * Looks like {"name":"ASC"} or {"name":"DESC"} in URL
     *
     * @param Request $request
     *
     * @return array|mixed
     */
    public function getOrder(Request $request)
    {
        return $request->getAttribute('orderByFilterParam', []);
    }

    /**
     * Get the limit param from the URL
     *
     * @param Request $request
     *
     * @return int
     */
    public function getLimit(Request $request)
    {
        return $request->getAttribute('limitFilterParam', null);
    }

    /**
     * Get the skip param from the url to find out the number of items to skip.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getSkip(Request $request)
    {
        return $request->getAttribute('skipFilterParam', 0);
    }
}

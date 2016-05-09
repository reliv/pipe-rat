<?php

namespace Reliv\PipeRat\ResourceController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Exception\MethodException;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\ServiceModel\RouteModel;

/**
 * Class AbstractResourceController
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class AbstractResourceController extends AbstractMiddleware implements ResourceController
{
    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
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
            throw new MethodException('Method does not exists');
        }

        return $this->$method($request, $response, $out);
    }

    /**
     * getUrlParam
     *
     * @param Request $request
     * @param string  $key
     * @param null    $default
     *
     * @return null
     */
    protected function getRouteParam(Request $request, $key, $default = null)
    {
        /** @var RouteModel $routeModel */
        $routeModel = $request->getAttribute(
            RouteModel::REQUEST_ATTRIBUTE_MODEL_ROUTE,
            []
        );

        return $routeModel->getRouteParam($key, $default);
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
        $allowDeepWheres = $this->getOption($request, 'allowDeepWheres', false);

        $where = $request->getAttribute('whereFilterParam', []);

        if ($allowDeepWheres) {
            return $where;
        }

        foreach ($where as $whereChunk) {
            if (is_array($whereChunk)) {
                throw new InvalidWhereException();
            }
        }

        return $where;
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

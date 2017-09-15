<?php

namespace Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class Fields
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Fields implements Middleware
{
    /**
     * Get the where param form the URL.
     *
     * Looks like:{"country":true} or {"country":{"name":true}}
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return mixed
     * @throws InvalidWhereException
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $params = $request->getQueryParams();

        if (!array_key_exists('fields', $params)) {
            return $next($request, $response);
        }

        $param = json_decode($params['fields'], true);

        $request = $request->withAttribute('propertyFilterParam', $param);

        return $next($request, $response);
    }
}

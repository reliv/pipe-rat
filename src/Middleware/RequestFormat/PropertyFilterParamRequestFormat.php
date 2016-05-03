<?php

namespace Reliv\PipeRat\Middleware\RequestFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class PropertyFilterParamRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class PropertyFilterParamRequestFormat extends AbstractRequestFormat implements Middleware
{
    /**
     * Get the where param form the URL.
     *
     * Looks like:{"country":true} or {"country":{"name":true}}
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $out
     *
     * @return mixed
     * @throws InvalidWhereException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $params = $request->getQueryParams();

        $param = [];

        if (!array_key_exists('properties', $params)) {
            return $out($request, $response);
        }

        $param = json_decode($params['properties'], true);

        $request = $request->withAttribute('propertyFilterParam', $param);

        return $out($request, $response);
    }
}

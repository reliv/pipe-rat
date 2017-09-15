<?php

namespace Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Middleware\RequestFormat\AbstractRequestFormat;

/**
 * Class Where
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Where extends AbstractRequestFormat implements Middleware
{
    /**
     * Get the where param form the URL.
     *
     * Looks like:{"country":"CAN"} or {"country":{"name":"United States"}}
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

        if (!array_key_exists('where', $params)) {
            return $next($request, $response);
        }

        $param = json_decode($params['where'], true);

        $request = $request->withAttribute('whereFilterParam', $param);

        $allowDeepWheres = $this->getOption($request, 'allowDeepWheres', false);

        if ($allowDeepWheres) {
            return $next($request, $response);
        }

        foreach ($param as $whereChunk) {
            if (is_array($whereChunk)) {
                throw new InvalidWhereException();
            }
        }

        return $next($request, $response);
    }
}

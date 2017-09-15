<?php

namespace Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class WhereFilterParamRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Where extends AbstractUrlEncodedCombinedFilter implements Middleware
{
    /**
     * Is used by parent getValue() function
     */
    const URL_KEY = 'where';

    /**
     * Get the where param form the URL.
     *
     * Looks like:{"country":"CAN"} or {"country":{"name":"United States"}}
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     *
     * @return mixed
     * @throws InvalidWhereException
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $where = $this->getValue($request);

        if ($where === null) {
            return $next($request, $response);
        }

        $allowDeepWheres = $this->getOption($request, 'allowDeepWheres', false);

        if ($allowDeepWheres) {
            return $next($request->withAttribute('whereFilterParam', $where), $response);
        }

        foreach ($where as $whereChunk) {
            if (is_array($whereChunk)) {
                //Should this be 400'ing instead of throwing?
                throw new InvalidWhereException();
            }
        }

        return $next($request->withAttribute('whereFilterParam', $where), $response);
    }
}

<?php

namespace Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter;

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
class Skip extends AbstractUrlEncodedCombinedFilter implements Middleware
{
    /**
     * Is used by parent getValue() function
     */
    const URL_KEY = 'skip';

    /**
     * Get the param from the URL
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
        $value = $this->getValue($request);

        if ($value !== null && $value != (int)$value) {
            //Should this be 400'ing instead of throwing?
            throw new InvalidWhereException(); 
        }

        return $next($request->withAttribute('skipFilterParam', $value), $response);
    }
}

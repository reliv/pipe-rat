<?php

namespace Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class Skip
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class Skip implements Middleware
{
    /**
     * Get the order param from the url to find out how the response
     * should be ordered.
     *
     * Looks like {"name":"ASC"} or {"name":"DESC"} in URL
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
        
        if (!array_key_exists('skip', $params)) {
            return $next($request, $response);
        }

        $param = (int)$params['skip'];

        $request = $request->withAttribute('skipFilterParam', $param);

        return $next($request, $response);
    }
}

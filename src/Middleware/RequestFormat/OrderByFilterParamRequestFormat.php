<?php

namespace Reliv\PipeRat\Middleware\RequestFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class OrderByFilterParamRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class OrderByFilterParamRequestFormat extends AbstractRequestFormat implements Middleware
{
    /**
     * Get the order param from the url to find out how the response
     * should be ordered.
     *
     * Looks like {"name":"ASC"} or {"name":"DESC"} in URL
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

        //
        if (array_key_exists('orderby', $params)) {
            $param = json_decode($params['orderby'], true);
        }

        $request = $request->withAttribute('orderByFilterParam', $param);

        return $out($request, $response);
    }
}

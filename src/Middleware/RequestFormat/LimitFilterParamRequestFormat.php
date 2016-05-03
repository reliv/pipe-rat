<?php

namespace Reliv\PipeRat\Middleware\RequestFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class LimitFilterParamRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class LimitFilterParamRequestFormat extends AbstractRequestFormat implements Middleware
{
    /**
     * __invoke
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

        if (array_key_exists('limit', $params)) {
            $param = (int) $params['limit'];
        }

        $request = $request->withAttribute('limitFilterParam', $param);

        return $out($request, $response);
    }
}

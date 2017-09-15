<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResponseFormatException;

/**
 * Class JsonErrorResponseFormat
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class JsonErrorResponseFormat extends JsonResponseFormat
{
    /**
     * __invoke
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     *
     * @return \Psr\Http\Message\MessageInterface
     * @throws ResponseFormatException
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $response = $next($request);

        if (!$this->isError($request, $response)) {
            return $response;
        }

        return parent::__invoke(
            $request,
            $response,
            function ($request) use ($response) {
                return $response;
            }
        );
    }
}

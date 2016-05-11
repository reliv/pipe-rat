<?php

namespace Reliv\PipeRat\Middleware\Header;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class AddResponseHeaders
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class AddResponseHeaders extends AbstractMiddleware implements Middleware
{
    /**
     * withAddedHeaders
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function withAddedHeaders(Request $request, Response $response)
    {
        $options = $this->getOptions($request);

        $headers = $options->get('headers', []);

        if (empty($headers)) {
            return $response;
        }

        foreach ($headers as $headerName => $values) {
            $response = $response->withHeader($headerName, $values);
        }

        return $response;
    }

    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return Response
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $response = $this->withAddedHeaders($request, $response);

        return $next($request, $response);
    }

}

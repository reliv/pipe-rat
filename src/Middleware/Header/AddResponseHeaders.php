<?php

namespace Reliv\PipeRat\Middleware\Header;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\OptionException;
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
     * getResponseWithOptionHeaders
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     * @throws OptionException
     */
    public function getResponseWithOptionHeaders(Request $request, Response $response)
    {
        $options = $this->getOptions($request);

        $headers = $options->get('headers', []);

        if (empty($headers)) {
            return $response;
        }

        foreach ($headers as $values) {
            if (!array_key_exists('name', $values) || !array_key_exists('value', $values)) {
                throw new OptionException('Header config requires both a name and a value key');
            }

            $response = $response->withAddedHeader($values['name'], $values['value']);
        }

        return $response;
    }

    /**
     * __invoke
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     *
     * @return Response
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $response = $next($request);

        $response = $this->getResponseWithOptionHeaders($request, $response);

        return $response;
    }

}

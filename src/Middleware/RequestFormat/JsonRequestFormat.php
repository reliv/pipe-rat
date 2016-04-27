<?php

namespace Reliv\PipeRat\Middleware\RequestFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class JsonRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class JsonRequestFormat implements Middleware
{
    /**
     * If the request is of type application/json, this middleware
     * decodes the json in the body and puts it in the "body" attribute
     * in the request.
     *
     * @param Request $request
     * @param Response $response
     * @param null|callable $out
     * @return null|Response
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if (in_array('application/json', $request->getHeader('Content-Type'))) {
            $body = json_decode($request->getBody()->getContents(), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $body = $response->getBody();
                $body->write(
                    'MIME type was "application/json" but invalid JSON in request body.'
                );

                return $response->withStatus(400)->withBody($body);
            }

            $request = $request->withAttribute('dataBody', $body);
        }

        return $out($request, $response);
    }
}

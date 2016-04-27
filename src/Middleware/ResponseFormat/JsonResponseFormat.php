<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResponseFormatException;
use Reliv\PipeRat\Http\DataResponse;

/**
 * Class ResponseFormat
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class JsonResponseFormat extends AbstractResponseFormat implements ResponseFormat
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
        if (!$this->isValidAcceptType($request)) {
            return $next($request, $response);
        }
        $dataModel = $this->getDataModel($response);

        $body = $response->getBody();
        $content = json_encode($dataModel);
        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new ResponseFormatException('json_encode failed to encode');
        }
        $body->write($content);

        return $response->withBody($body)->withHeader(
            'Content-Type',
            'application/json'
        );
    }
}

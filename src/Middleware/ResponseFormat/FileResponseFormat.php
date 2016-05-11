<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResponseFormatException;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class FileResponseFormat
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class FileResponseFormat extends AbstractResponseFormat implements Middleware
{
    /**
     * @var array
     */
    protected $defaultAcceptTypes
        = [];

    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
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
        
        $options = $this->getOptions($request);
        $contentType = $options->get('contentType', 'application/octet-stream');

        return $response->withHeader(
            'Content-Type',
            $contentType
        );
    }
}

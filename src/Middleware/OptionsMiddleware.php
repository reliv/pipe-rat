<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\MiddlewareOptions;

/**
 * Class OptionsMiddleware
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class OptionsMiddleware implements Middleware
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * OptionsMiddleware constructor.
     *
     * @param Options $options
     */
    public function __construct(
        Options $options
    ) {
        $this->options = $options;
    }

    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        $request = $request->withAttribute(MiddlewareOptions::getName(), $this->options);

        return $next($request, $response);
    }
}

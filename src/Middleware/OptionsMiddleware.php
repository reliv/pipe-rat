<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Reliv\PipeRat\Options\Options;

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
     * Request Attribute Id
     */
    const REQUEST_ATTRIBUTE_OPTIONS = 'api-lib-resource-options';

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
     * @param callable|null $out
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $request = $request->withAttribute(self::REQUEST_ATTRIBUTE_OPTIONS, $this->options);
        return $out($request, $response);
    }
}

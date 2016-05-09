<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\RequestAttribute;

/**
 * Class OptionsMiddleware
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class OptionsMiddleware implements Middleware, RequestAttribute
{
    /**
     * Request Attribute Id
     */
    const ATTRIBUTE_NAME = 'pipe-rat-middleware-options';

    /**
     * getName
     *
     * @return string
     */
    public static function getName()
    {
        return self::ATTRIBUTE_NAME;
    }

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
     * getName
     *
     * @return string
     */
    public function getAttributeName()
    {
        return self::getName();
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
        $request = $request->withAttribute(self::getName(), $this->options);

        return $out($request, $response);
    }
}

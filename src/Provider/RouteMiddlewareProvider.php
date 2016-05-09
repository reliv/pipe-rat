<?php

namespace Reliv\PipeRat\Provider;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\RequestAttribute\Paths;
use Reliv\PipeRat\RequestAttribute\RequestAttribute;

/**
 * Class MiddlewareProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface RouteMiddlewareProvider extends MiddlewareProvider
{
    /**
     * withPaths
     * 
     * set Reliv\PipeRat\RequestAttribute\Paths attribute = array ['/{path}' => ['{verb}' => 'resourceId']]
     *
     * @param Request $request
     *
     * @return Request
     */
    public function withPaths(Request $request);
}

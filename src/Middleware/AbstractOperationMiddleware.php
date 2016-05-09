<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Provider\MiddlewareProvider;
use Reliv\PipeRat\Provider\RouteMiddlewareProvider;
use Reliv\PipeRat\ServiceModel\ErrorModel;
use Reliv\PipeRat\ServiceModel\MethodModel;
use Reliv\PipeRat\ServiceModel\ResourceModel;
use Reliv\PipeRat\ServiceModel\RouteModel;
use Reliv\PipeRat\Provider\ModelProvider;
use Reliv\PipeRat\Provider\ResourceModelProvider;

/**
 * Class AbstractOperationMiddleware
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   MiddlewareInterface
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractOperationMiddleware extends AbstractMiddleware
{
    /**
     * @var RouteMiddlewareProvider
     */
    protected $routeMiddlewareProvider;

    /**
     * @var MiddlewareProvider
     */
    protected $errorMiddlewareProvider;

    /**
     * @var MiddlewareProvider
     */
    protected $middlewareProvider;

    /**
     * AbstractOperationMiddleware constructor.
     *
     * @param RouteMiddlewareProvider $routeMiddlewareProvider
     * @param MiddlewareProvider      $errorMiddlewareProvider
     * @param MiddlewareProvider      $middlewareProvider
     */
    public function __construct(
        RouteMiddlewareProvider $routeMiddlewareProvider,
        MiddlewareProvider $errorMiddlewareProvider,
        MiddlewareProvider $middlewareProvider
    ) {
        $this->routeMiddlewareProvider = $routeMiddlewareProvider;
        $this->errorMiddlewareProvider = $errorMiddlewareProvider;
        $this->middlewareProvider = $middlewareProvider;
    }

    /**
     * getRouteMiddlewareProvider
     *
     * @return RouteMiddlewareProvider
     */
    public function getRouteMiddlewareProvider() {
        return $this->routeMiddlewareProvider;
    }

    /**
     * getErrorMiddlewareProvider
     *
     * @return MiddlewareProvider
     */
    public function getErrorMiddlewareProvider() {
        return $this->errorMiddlewareProvider;
    }
    
    /**
     * getMiddlewareProvider
     *
     * @return MiddlewareProvider
     */
    public function getMiddlewareProvider() {
        return $this->middlewareProvider;
    }
}

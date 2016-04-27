<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\ServiceModel\ErrorModel;
use Reliv\PipeRat\ServiceModel\MethodModel;
use Reliv\PipeRat\ServiceModel\ResourceModel;
use Reliv\PipeRat\ServiceModel\RouteModel;
use Reliv\PipeRat\Provider\ModelProvider;
use Reliv\PipeRat\Provider\ResourceModelProvider;

/**
 * Class AbstractModelMiddleware
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
abstract class AbstractModelMiddleware extends AbstractMiddleware
{
    /**
     * @var ResourceModelProvider
     */
    protected $resourceModelProvider;

    /**
     * @var ModelProvider
     */
    protected $routeModelProvider;

    /**
     * @var ModelProvider
     */
    protected $errorModelProvider;

    /**
     * AbstractModelMiddleware constructor.
     *
     * @param ModelProvider         $routeModelProvider
     * @param ModelProvider         $errorModelProvider
     * @param ResourceModelProvider $resourceModelProvider
     */
    public function __construct(
        ModelProvider $routeModelProvider,
        ModelProvider $errorModelProvider,
        ResourceModelProvider $resourceModelProvider
    ) {
        $this->routeModelProvider = $routeModelProvider;
        $this->errorModelProvider = $errorModelProvider;
        $this->resourceModelProvider = $resourceModelProvider;
    }

    /**
     * getErrorModel
     *
     * @return ErrorModel
     */
    public function getErrorModel() {
        return $this->errorModelProvider->get();
    }

    /**
     * getRouteModel
     *
     * @param Request $request
     * @param null    $default
     *
     * @return mixed|RouteModel
     */
    public function getRouteModel(
        Request $request,
        $default = null
    ) {
        $routeModel = $request->getAttribute(
            RouteModel::REQUEST_ATTRIBUTE_MODEL_ROUTE,
            $default
        );

        if ($routeModel instanceof RouteModel) {
            return $routeModel;
        }

        return $this->routeModelProvider->get();
    }

    /**
     * getResourceModel
     *
     * @param Request $request
     * @param string  $resourceKey
     *
     * @return ResourceModel
     */
    public function getResourceModel(
        Request $request,
        $resourceKey = null
    ) {
        $resourceKey = $this->getResourceKey($request, $resourceKey);

        return $this->resourceModelProvider->get($resourceKey);
    }

    /**
     * getMethodModel
     *
     * @param Request $request
     * @param null    $resourceKey
     * @param null    $methodKey
     *
     * @return null|MethodModel
     */
    public function getMethodModel(
        Request $request,
        $resourceKey = null,
        $methodKey = null
    ) {
        $resourceModel = $this->getResourceModel($request, $resourceKey);

        return $resourceModel->getMethodModel(
            $this->getMethodKey($request, $methodKey)
        );
    }
}

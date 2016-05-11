<?php

namespace Reliv\PipeRat\Provider;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResourceException;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Operation\OperationCollection;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\ResourceKey;

/**
 * Class BasicConfigMiddlewareProvider
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
class BasicConfigMiddlewareProvider extends AbstractBasicConfigMiddlewareProvider implements MiddlewareProvider
{
    /**
     * @var array
     */
    protected $resourceConfig;

    /**
     * @var array
     */
    protected $operations = [];

    /**
     * getResourceConfig
     *
     * @return array|mixed
     */
    protected function getResourceConfig()
    {
        if (!empty($this->resourceConfig)) {
            return $this->resourceConfig;
        }

        $resourceConfig = $this->config['resources'];
        $defaultConfig = $this->config['defaultResourceConfig'];

        foreach ($resourceConfig as $resourceName => $resourceProperties) {
            $defaultResourcePropertyKey = 'default:empty';
            if (array_key_exists('extendsConfig', $resourceProperties)) {
                $defaultResourcePropertyKey = $resourceProperties['extendsConfig'];
            }

            $resourceConfig = array_replace_recursive(
                $defaultConfig[$defaultResourcePropertyKey],
                $resourceProperties
            );

            $this->resourceConfig[$resourceName] = new GenericOptions($resourceConfig);
        }

        return $this->resourceConfig;
    }

    /**
     * buildResourceOperationCollection
     *
     * @param string $resourceKey
     *
     * @return OperationCollection
     * @throws ResourceException
     */
    protected function buildResourceOperationCollection($resourceKey)
    {
        if (array_key_exists($resourceKey, $this->operations)) {
            return $this->operations[$resourceKey];
        }

        $resourceConfig = $this->getResourceConfig();

        $resourceKeys = explode('::', $resourceKey);
        $resourceName = $resourceKeys[0];
        $methodName = $resourceKeys[1];
        $controllerMethod = $resourceKeys[2];

        if (!array_key_exists($resourceName, $resourceConfig)) {
            throw new ResourceException('Resource config missing for ' . $resourceName);
        }
        
        /** @var Options $resourceOptions */
        $resourceOptions = $resourceConfig[$resourceName];
        $methods = $resourceOptions->get('methods', []);

        if (!array_key_exists($methodName, $methods)) {
            throw new ResourceException('Resource method config missing for ' . $methodName);
        }

        $operations = new BasicOperationCollection();

        $methodOptions = new GenericOptions($methods[$methodName]);

        // Controller Pre
        $this->buildOperations(
            $operations,
            $resourceOptions->get('preServiceNames', []),
            $resourceOptions->getOptions('preServiceOptions'),
            $resourceOptions->getOptions('preServicePriority')
        );

        // Method Pre
        $this->buildOperations(
            $operations,
            $methodOptions->get('preServiceNames', []),
            $methodOptions->getOptions('preServiceOptions'),
            $methodOptions->getOptions('preServicePriority')
        );

        // ControllerMethod
        $controllerOptions = $resourceOptions->getOptions('controllerServiceOptions');
        $controllerOptions->set('method', $controllerMethod);
        $operations->addOperation(
            $this->buildOperation(
                $resourceOptions->get('controllerServiceName'),
                $this->serviceManager->get($resourceOptions->get('controllerServiceName')),
                $controllerOptions,
                1000
            )
        );

        // Method Post
        $this->buildOperations(
            $operations,
            $methodOptions->get('postServiceNames', []),
            $methodOptions->getOptions('postServiceOptions'),
            $methodOptions->getOptions('postServicePriority')
        );

        // Controller Post
        $this->buildOperations(
            $operations,
            $resourceOptions->get('postServiceNames', []),
            $resourceOptions->getOptions('postServiceOptions'),
            $resourceOptions->getOptions('postServicePriority')
        );

        $this->operations[$resourceKey] = $operations;

        return $this->operations[$resourceKey];
    }

    /**
     * buildPipe
     *
     * @param MiddlewarePipe $middlewarePipe
     * @param Request        $request
     *
     * @return MiddlewarePipe
     * @throws ResourceException
     */
    public function buildPipe(
        MiddlewarePipe $middlewarePipe,
        Request $request
    ) {
        $resourceKey = $request->getAttribute(ResourceKey::getName());

        if ($resourceKey === null) {
            throw new ResourceException('ResourceKey not set: ' . $resourceKey);
        }

        $operations = $this->buildResourceOperationCollection($resourceKey);

        $middlewarePipe->pipeOperations(
            $operations
        );

        return $request;
    }
}

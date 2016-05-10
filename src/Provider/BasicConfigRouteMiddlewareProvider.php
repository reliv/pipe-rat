<?php

namespace Reliv\PipeRat\Provider;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ConfigException;
use Reliv\PipeRat\Exception\MethodException;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Operation\OperationCollection;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\Paths;

/**
 * Class BasicConfigRouteMiddlewareProvider
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
class BasicConfigRouteMiddlewareProvider extends BasicConfigMiddlewareProvider implements RouteMiddlewareProvider
{
    /**
     * @var OperationCollection
     */
    protected $operationCollection;

    /**
     * @var array
     */
    protected $paths = [];

    /**
     * buildOperationCollection
     *
     * @return OperationCollection
     * @throws \Exception
     */
    protected function buildOperationCollection()
    {
        if (!empty($this->operationCollection)) {
            return $this->operationCollection;
        }

        $configOptions = $this->getConfigOptions();

        $operationServiceNames = $configOptions->get('routeServiceNames', []);

        if (empty($operationServiceNames)) {
            throw new ConfigException('routeServiceNames missing in config');
        }

        $this->operationCollection = new BasicOperationCollection();
        $operationOptions = $configOptions->getOptions('routeServiceOptions');
        $operationPriorities = $configOptions->getOptions('routeServicePriority');

        $this->buildOperations(
            $this->operationCollection,
            $operationServiceNames,
            $operationOptions,
            $operationPriorities
        );

        return $this->operationCollection;
    }

    /**
     * withPaths
     *
     * set Reliv\PipeRat\RequestAttribute\Paths attribute = array ['/{path}' => ['{verb}' => 'resourceKey']]
     *
     * @param Request $request
     *
     * @return Request
     */
    public function withPaths(Request $request)
    {
        if (!empty($this->paths)) {
            $request->withAttribute(Paths::getName(), $this->paths);

            return $request;
        }

        $resourceConfig = $this->getResourceConfig();

        /**
         * @var string  $resourceName
         * @var Options $resourceOptions
         */
        foreach ($resourceConfig as $resourceName => $resourceOptions) {
            $resourcePath = $resourceOptions->get('path', '/' . $resourceName);

            $methodsAllowed = $resourceOptions->get('methodsAllowed', []);
            $methods = $resourceOptions->get('methods', []);
            $methodPriority = $resourceOptions->get('methodPriority', []);

            foreach ($methods as $methodName => $methodProperties) {
                if (!in_array($methodName, $methodsAllowed)) {
                    continue;
                }
                $methodOptions = new GenericOptions($methodProperties);

                $fullPath = $resourcePath . $methodOptions->get('path', '/' . $methodName);

                if (!array_key_exists($resourcePath, $this->paths)) {
                    $this->paths[$resourcePath] = [];
                }

                $this->paths[$fullPath][$methodOptions->get('httpVerb', 'GET')] = $resourceName . '::' . $methodName;
            }
        }

        // Reverse to priority
        $this->paths = array_reverse($this->paths, true);

        var_dump($this->paths); die;

        return $request->withAttribute(Paths::getName(), $this->paths);
    }

    /**
     * @todo Implement ME
     * buildMethods
     *
     * @param string $resourceName
     * @param string $resourcePath
     * @param array  $methodsAllowed
     * @param array  $methods
     * @param array  $methodPriority
     *
     * @return void
     * @throws MethodException
     */
    protected function buildMethods(
        $resourceName,
        $resourcePath,
        array $methodsAllowed,
        array $methods,
        array $methodPriority
    ) {
        $queue = new \SplPriorityQueue();

        $defaultPriority = 0;

        foreach ($methods as $methodName) {
            if (!in_array($methodName, $methodsAllowed)) {
                continue;
            }

            if (!array_key_exists($methodName, $methodPriority)) {
                $priority = $methodPriority[$methodName];
            } else {
                $priority = $defaultPriority;
                $defaultPriority++;
            }

            $queue->insert($methodName, $priority);
        }

        $reversedOrder = [];
        foreach ($queue as $methodName) {
            array_unshift($reversedOrder, $methodName);
        }

        foreach ($reversedOrder as $methodName) {
            $methodProperties = $methods[$methodName];
            $methodOptions = new GenericOptions($methodProperties);

            $fullPath = $resourcePath . $methodOptions->get('path', '/' . $methodName);

            if (!array_key_exists($resourcePath, $this->paths)) {
                $this->paths[$resourcePath] = [];
            }

            $this->paths[$fullPath][$methodOptions->get('httpVerb', 'GET')] = $resourceName . '::' . $methodName;
        }
    }

    /**
     * buildPipe
     *
     * @param MiddlewarePipe $middlewarePipe
     * @param Request        $request
     *
     * @return Request
     * @throws \Exception
     */
    public function buildPipe(
        MiddlewarePipe $middlewarePipe,
        Request $request
    ) {
        $request = $this->withPaths($request);

        $middlewarePipe->pipeOperations(
            $this->buildOperationCollection()
        );

        return $request;
    }
}

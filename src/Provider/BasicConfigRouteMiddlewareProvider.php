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

            $this->buildMethods(
                $resourceName,
                $resourcePath,
                $methodsAllowed,
                $methods,
                $methodPriority
            );
        }

        return $request->withAttribute(Paths::getName(), $this->paths);
    }

    /**
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
        if(empty($methodPriority)) {
            $this->buildSimpleMethods(
                $resourceName,
                $resourcePath,
                $methodsAllowed,
                $methods
            );
            return;
        }

        $queue = new \SplPriorityQueue();

        $defaultPriority = 1;

        foreach ($methods as $methodName => $methodProperties) {
            if (!in_array($methodName, $methodsAllowed)) {
                continue;
            }
            if (array_key_exists($methodName, $methodPriority)) {
                $priority = $methodPriority[$methodName];
            } else {
                $priority = $defaultPriority;
                $defaultPriority++;
            }
            if($resourceName == "it-pws-profile") {
                var_dump($methodName, $priority);
            }
            $queue->insert($methodName, $priority);
        }

        foreach ($queue as $methodName) {
            $methodProperties = $methods[$methodName];
            $methodOptions = new GenericOptions($methodProperties);

            $fullPath = $resourcePath . $methodOptions->get('path', '/' . $methodName);

            if (!array_key_exists($fullPath, $this->paths)) {
                $this->paths[$fullPath] = [];
            }

            $this->paths[$fullPath][$methodOptions->get('httpVerb', 'GET')] = $resourceName . '::' . $methodName;
        }
    }


    /**
     * buildSimpleMethods
     *
     * @param       $resourceName
     * @param       $resourcePath
     * @param array $methodsAllowed
     * @param array $methods
     *
     * @return void
     */
    protected function buildSimpleMethods(
        $resourceName,
        $resourcePath,
        array $methodsAllowed,
        array $methods
    ) {
        $methods = array_reverse($methods, true);

        foreach ($methods as $methodName => $methodProperties) {
            if (!in_array($methodName, $methodsAllowed)) {
                continue;
            }
            $methodOptions = new GenericOptions($methodProperties);

            $fullPath = $resourcePath . $methodOptions->get('path', '/' . $methodName);

            if (!array_key_exists($fullPath, $this->paths)) {
                $this->paths[$fullPath] = [];
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

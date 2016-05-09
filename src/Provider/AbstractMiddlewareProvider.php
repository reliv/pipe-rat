<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResourceException;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\Operation\BasicOperation;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\ResourceKey;

/**
 * Class AbstractMiddlewareProvider
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
abstract class AbstractMiddlewareProvider
{
    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * @var Options
     */
    protected $configOptions;

    /**
     * @param ContainerInterface $serviceManager
     */
    public function __construct(
        $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
    }

    /**
     * buildResourceOperationCollection
     *
     * @param string $resourceKey
     *
     * @return BasicOperationCollection
     * @throws ResourceException
     */
    abstract protected function buildResourceOperationCollection($resourceKey);

    /**
     * getConfigOptions
     *
     * @return Options
     */
    abstract protected function getConfigOptions();

    /**
     * buildOperations
     *
     * @param BasicOperationCollection $operationCollection
     * @param array                    $operationServiceNames
     * @param Options                  $operationOptions
     * @param Options                  $operationPriorities
     *
     * @return void
     */
    protected function buildOperations(
        BasicOperationCollection $operationCollection,
        array $operationServiceNames,
        Options $operationOptions,
        Options $operationPriorities
    ) {
        $queue = new \SplPriorityQueue();

        foreach ($operationServiceNames as $name => $middlewareService) {
            $queue->insert(
                $name,
                $operationPriorities->get($name, 0)
            );
        }

        foreach ($queue as $name) {
            $operationCollection->addOperation(
                $this->buildOperation(
                    $name,
                    $this->serviceManager->get($operationServiceNames[$name]),
                    $operationOptions->getOptions($name),
                    $operationPriorities->get($name, 0)
                )
            );
        }
    }

    /**
     * buildOperation
     *
     * @param string          $name
     * @param callable|object $middleware Middleware  $serviceName
     * @param Options         $options
     * @param int             $priority
     *
     * @return BasicOperation
     */
    protected function buildOperation($name, $middleware, Options $options, $priority)
    {
        return new BasicOperation(
            $name,
            $middleware,
            $options,
            $priority
        );
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

        $middlewarePipe->pipeOperations(
            $this->buildResourceOperationCollection($resourceKey)
        );
    }
}

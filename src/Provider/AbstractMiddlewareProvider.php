<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Reliv\PipeRat\Operation\BasicOperation;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Options\Options;

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

        $defaultPriority = count($operationServiceNames);

        foreach ($operationServiceNames as $name => $middlewareService) {
            // Allows over-riding with nulls
            if (empty($middlewareService)) {
                continue;
            }

            $priority = $operationPriorities->get($name);

            if (empty($priority)) {
                $priority = $defaultPriority;
                $defaultPriority--;
            }

            $queue->insert(
                $name,
                $priority
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
}

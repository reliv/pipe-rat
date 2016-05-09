<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResourceException;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\Operation\BasicOperation;
use Reliv\PipeRat\Operation\BasicOperationCollection;
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
            // Allows over-riding
            if (empty($operationServiceNames[$name])) {
                continue;
            }
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

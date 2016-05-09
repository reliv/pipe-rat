<?php

namespace Reliv\PipeRat\Middleware;

use Reliv\PipeRat\Operation\Operation;
use Reliv\PipeRat\Operation\OperationCollection;

/**
 * Class MiddlewarePipe
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class MiddlewarePipe extends \Zend\Stratigility\MiddlewarePipe
{
    /**
     * pipeOperations
     *
     * @param OperationCollection $operationCollection
     *
     * @return void
     */
    public function pipeOperations(
        OperationCollection $operationCollection
    ) {
        $operations = $operationCollection->getOperations();
        /**
         * @var string    $name
         * @var Operation $operation
         */
        foreach ($operations as $name => $operation) {
            $this->pipeOperation(
                $operation
            );
        }
    }

    /**
     * pipeOperation
     *
     * @param Operation $operation
     *
     * @return void
     */
    public function pipeOperation(
        Operation $operation
    ) {
        $options = $operation->getOptions();
        $middlewareOptions = new OptionsMiddleware($options);
        $this->pipe($middlewareOptions);
        $this->pipe($operation->getMiddleware());
    }
}

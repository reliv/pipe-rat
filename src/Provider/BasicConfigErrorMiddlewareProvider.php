<?php

namespace Reliv\PipeRat\Provider;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ConfigException;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Operation\OperationCollection;

/**
 * Class BasicConfigErrorMiddlewareProvider
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
class BasicConfigErrorMiddlewareProvider extends AbstractBasicConfigMiddlewareProvider implements MiddlewareProvider
{
    /**
     * @var OperationCollection
     */
    protected $operationCollection;

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

        $operationServiceNames = $configOptions->get('errorServiceNames', []);

        $this->operationCollection = new BasicOperationCollection();
        $operationOptions = $configOptions->getOptions('errorServiceOptions');
        $operationPriorities = $configOptions->getOptions('errorServicePriority');

        $this->buildOperations(
            $this->operationCollection,
            $operationServiceNames,
            $operationOptions,
            $operationPriorities
        );

        return $this->operationCollection;
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
        $middlewarePipe->pipeOperations(
            $this->buildOperationCollection()
        );

        return $request;
    }
}

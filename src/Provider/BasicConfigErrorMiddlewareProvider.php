<?php

namespace Reliv\PipeRat\Provider;

use Reliv\PipeRat\Exception\ConfigException;
use Reliv\PipeRat\Operation\BasicOperationCollection;

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
     * buildResourceOperationCollection
     *
     * @param string $resourceKey
     *
     * @return BasicOperationCollection
     * @throws \Exception
     */
    protected function buildResourceOperationCollection($resourceKey)
    {
        $configOptions = $this->getConfigOptions();

        $operationServiceNames = $configOptions->get('errorServiceNames', []);

        if (empty($operationServiceNames)) {
            throw new ConfigException('errorServiceNames missing in config');
        }

        $operations = new BasicOperationCollection();
        $operationOptions = $configOptions->getOptions('errorServiceOptions');
        $operationPriorities = $configOptions->getOptions('errorServicePriority');

        $this->buildOperations(
            $operations,
            $operationServiceNames,
            $operationOptions,
            $operationPriorities
        );
    }
}

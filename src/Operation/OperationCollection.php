<?php

namespace Reliv\PipeRat\Operation;

use Reliv\PipeRat\Exception\ServiceMissingException;

/**
 * Class OperationCollection
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ServiceModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface OperationCollection
{
    /**
     * getServiceModels
     *
     * In priority order
     *
     * @return array ['{alias}' => {ServiceModel}]
     * @throws ServiceMissingException
     */
    public function getOperations();

    /**
     * addOperation
     *
     * @param Operation $operation
     *
     * @return mixed
     */
    public function addOperation(Operation $operation);

    /**
     * getOperation
     *
     * @param string $alias
     *
     * @return Operation
     */
    public function getOperation($alias);
}

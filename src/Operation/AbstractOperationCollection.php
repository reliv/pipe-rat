<?php

namespace Reliv\PipeRat\Operation;

use Reliv\PipeRat\Exception\ServiceMissingException;

/**
 * Class AbstractOperationCollection
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
abstract class AbstractOperationCollection
{
    /**
     * @var array
     */
    protected $operations = [];

    /**
     * getServiceModels
     *
     * In priority order
     *
     * @return array ['{alias}' => {ServiceModel}]
     * @throws \Exception
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * addOperation
     *
     * @param Operation $operation
     *
     * @return mixed
     */
    public function addOperation(Operation $operation)
    {
        $this->operations[$operation->getName()] = $operation;
    }

    /**
     * getOperation
     *
     * @param      $alias
     * @param null $default
     *
     * @return mixed|null
     */
    public function getOperation($alias, $default = null)
    {
        $alias = (string)$alias;
        if (array_key_exists($alias, $this->operations)) {
            return $this->operations[$alias];
        }

        return $default;
    }
}

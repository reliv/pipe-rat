<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * interface ResponsePropertiesInterface
 *
 * PropertiesInterface Interface
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Rcm\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface PropertiesInterface
{
    /**
     * setProperties
     *
     * @param \Traversable $data
     * @param array        $properties List of properties to include
     *
     * @return mixed
     */
    public function setProperties(
        \Traversable $data,
        $properties = []
    );

    /**
     * getProperties
     *   Properties List of properties to include
     *    [
     *    '{property}' => {bool}
     *    '{propertyCollection}' => ['{property}' => {bool}]
     *    ]
     * 
     * @param array $properties List of properties to include
     *
     * @return array
     */
    public function getProperties(
        $properties = []
    );

    /**
     * setAllProperties
     *
     * @param \Traversable $data
     *
     * @return mixed
     */
    public function setAllProperties(
        \Traversable $data
    );

    /**
     * getAllProperties
     *
     * @return mixed
     */
    public function getAllProperties();
}

<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 *  ResponseProperties
 *
 * Properties
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Rcm\Entity
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface Properties
{
    /**
     * setProperties
     * List of properties to include
     *  [
     *   '{property}' => {bool}
     *   '{propertyCollection}' => ['{property}' => {bool}]
     *  ]
     *
     * @param array|\Traversable $data
     * @param array              $properties
     *
     * @return mixed
     */
    public function setProperties(
        $data,
        $properties = []
    );

    /**
     * getProperties
     * Properties List of properties to include
     *  [
     *    '{property}' => {bool}
     *    '{propertyCollection}' => ['{property}' => {bool}]
     *  ]
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
     * @param array|\Traversable $data
     *
     * @return mixed
     */
    public function setAllProperties(
        $data
    );

    /**
     * getAllProperties
     *
     * @return array
     */
    public function getAllProperties();
}

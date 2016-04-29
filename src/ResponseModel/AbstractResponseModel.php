<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class AbstractResponseModel
 *
 * AbstractResponseModel
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ResponseModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractResponseModel implements ResponseModel
{
    /**
     * const
     */
    const METHOD_GET_PREFIX = 'get';

    /**
     * const
     */
    const METHOD_BOOL_GET_PREFIX = 'is';

    /**
     * const
     */
    const METHOD_BOOL_SET_PREFIX = 'set';

    /**
     * setProperties
     *
     * @param \Traversable $data
     * @param array        $properties List of properties to include
     *
     * @return mixed
     */
    public function setProperties(
        $data,
        $properties = []
    ) {
        foreach ($properties as $property => $value) {

            if ($value === false) {
                continue;
            }

            $method = self::METHOD_BOOL_SET_PREFIX . ucfirst($property);

            if (method_exists($this, $method)) {
                $this->$method($data[$property]);
            }
        }
    }

    /**
     * getProperties
     *
     * @param array $properties List of properties to include
     *
     * @return array
     */
    public function getProperties(
        $properties = []
    ) {
        $data = [];

        foreach ($properties as $property => $value) {

            if ($value === false) {
                continue;
            }

            $method = self::METHOD_GET_PREFIX . ucfirst($property);

            if (method_exists($this, $method)) {
                $data[$property] = $this->$method();
            }

            $methodBool = self::METHOD_BOOL_GET_PREFIX . ucfirst($property);

            if (method_exists($this, $methodBool)) {
                $data[$property] = $this->$methodBool();
            }

            if (is_array($value)) {
                $data[$property] = $this->getCollectionProperties(
                    $data[$property],
                    $value
                );
            }
        }

        return $data;
    }

    /**
     * setAllProperties
     *
     * @param array|\Traversable $data
     *
     * @return mixed
     */
    public function setAllProperties(
        $data
    ) {
        $properties = get_object_vars($this);
        foreach ($properties as $propertyName => $value) {
            $properties[$propertyName] = true;
        }
        $this->setProperties($data, $properties);
    }

    /**
     * getAllProperties
     *
     * @return mixed
     */
    public function getAllProperties()
    {
        $properties = get_object_vars($this);
        foreach ($properties as $propertyName => $value) {
            $properties[$propertyName] = true;
        }

        return $this->getAllProperties();
    }

    /**
     * jsonSerialize
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->getAllProperties();
    }

    /**
     * getCollectionProperties
     *
     * @param array|\Traversable $collection
     * @param array              $properties
     *
     * @return array
     */
    protected function getCollectionProperties(
        $collection,
        $properties = []
    ) {
        $data = [];

        if (!is_array($collection) && !$collection instanceof \Traversable) {
            return $data;
        }

        /** @var ResponseModel $model */
        foreach ($collection as $model) {
            if (!$model instanceof ResponseModel) {
                // noth can be done
                return $data;
            }
            $data[] = $model->getProperties(
                $properties
            );
        }

        return $data;
    }
}

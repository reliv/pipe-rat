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
 * @copyright 2015 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractResponseModel implements ResponseModelInterface
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
    ) {
        $prefix = 'get';
        $data = [];

        foreach ($properties as $property => $value) {

            if($value === false) {
                continue;
            }

            $method = $prefix . ucfirst($property);

            if (method_exists($this, $method)) {
                $data[$property] = $this->$method();
            }

            if(is_array($value)) {
                $data[$property] = $this->getCollectionProperties($data[$property], $value);
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
        $prefix = 'get';
        $data = [];

        foreach ($properties as $property => $value) {

            if($value === false) {
                continue;
            }

            $method = $prefix . ucfirst($property);

            if (method_exists($this, $method)) {
                $data[$property] = $this->$method();
            }

            if(is_array($value)) {
                $data[$property] = $this->getCollectionProperties($data[$property], $value);
            }
        }

        return $data;
    }

    /**
     * setAllProperties
     *
     * @param \Traversable $data
     *
     * @return mixed
     */
    public function setAllProperties(
        \Traversable $data
    ) {
        
    }

    /**
     * getAllProperties
     *
     * @return mixed
     */
    public function getAllProperties()
    {
        
    }

    /**
     * jsonSerialize
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->getProperties();
    }

    /**
     * setCollectionProperties
     *
     * @param \Traversable $modelCollection
     * @param array        $includeProperties
     *
     * @return array
     */
    protected function setCollectionProperties(
        \Traversable $modelCollection,
        $includeProperties = []
    ) {
        $array = [];

        /** @var PropertiesInterface $model */
        foreach ($modelCollection as $model) {
            $array[] = $model->setProperties($includeProperties);
        }
    }

    /**
     * getCollectionProperties
     *
     * @param \Traversable $modelCollection
     * @param array        $includeProperties
     *
     * @return array
     */
    protected function getCollectionProperties(
        \Traversable $modelCollection,
        $includeProperties = []
    ) {
        $array = [];

        /** @var PropertiesInterface $model */
        foreach ($modelCollection as $model) {
            $array[] = $model->getProperties($includeProperties);
        }

        return $array;
    }
}

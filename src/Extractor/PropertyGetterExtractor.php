<?php

namespace Reliv\PipeRat\Extractor;

use Reliv\PipeRat\Exception\ExtractorException;
use Reliv\PipeRat\Options\Options;

/**
 * Class PropertyGetterExtractor
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class PropertyGetterExtractor extends AbstractExtractor implements Extractor
{
    /**
     * const
     */
    const METHOD_PREFIX = 'get';

    /**
     * const
     */
    const METHOD_BOOL_PREFIX = 'is';

    /**
     * extract
     *
     * @param \stdClass|array $dataModel
     * @param Options $options
     *
     * @return array
     */
    public function extract($dataModel, Options $options)
    {
        $properties = $this->getPropertyList($options, null);

        // If no properties are set, we get them all if we can
        if (!is_array($properties)) {
            $properties = $this->getPropertyListFromProperties($dataModel);
        }

        $depthLimit = $this->getPropertyDepthLimit($options, 1);

        return $this->getProperties($dataModel, $properties, 1, $depthLimit);
    }

    /**
     * getProperties
     *
     * @param \stdClass|array $dataModel $dataModel
     * @param array $properties
     * @param int $depth
     * @param int $depthLimit
     *
     * @return array
     */
    protected function getProperties(
        $dataModel,
        array $properties,
        $depth,
        $depthLimit
    ) {
        $data = [];

        if ($this->isOverDepthLimit($depth, $depthLimit)) {
            return $data;
        }

        foreach ($properties as $property => $configValue) {

            if ($configValue === false) {
                continue;
            }

            $data[$property] = $dataModel;

            if (is_object($dataModel)) {
                $data[$property] = $this->getDataFromObject($property, $dataModel);
            }

            if (is_array($dataModel)) {
                $data[$property] = $this->getDataFromArray($property, $dataModel);
            }

            if (is_array($configValue)) {
                $data[$property] = $this->getCollectionProperties(
                    $data[$property],
                    $configValue,
                    $depth + 1,
                    $depthLimit
                );
            }
        }

        return $data;
    }

    /**
     * getDataFromArray
     *
     * @param string $property
     * @param array $dataModel
     * @param null $default
     *
     * @return mixed|null
     */
    protected function getDataFromArray($property, array $dataModel, $default = null)
    {
        if (array_key_exists($property, $dataModel)) {
            return $dataModel[$property];
        }

        return $default;
    }

    /**
     * getDataFromObject
     *
     * @param string $property
     * @param \stdClass $dataModel
     * @param null $default
     *
     * @return mixed|null
     */
    protected function getDataFromObject($property, $dataModel, $default = null)
    {
        $methodBool = self::METHOD_BOOL_PREFIX . ucfirst($property);

        if (method_exists($dataModel, $methodBool)) {
            return $dataModel->$methodBool();
        }

        $method = self::METHOD_PREFIX . ucfirst($property);

        if (method_exists($dataModel, $method)) {
            return $dataModel->$method();
        }

        return $default;
    }

    /**
     * getCollectionProperties
     *
     * @param array|\Traversable $collectionDataModel
     * @param array $properties
     * @param int $depth
     * @param int $depthLimit
     *
     * @return array
     * @throws ExtractorException
     */
    protected function getCollectionProperties(
        $collectionDataModel,
        array $properties = [],
        $depth,
        $depthLimit
    ) {
        if (!$this->isTraversable($collectionDataModel)) {
            throw new ExtractorException('Properties are not traversable, got: ' . gettype($collectionDataModel));
        }

        $data = [];

        if ($this->isOverDepthLimit($depth, $depthLimit)) {
            return $data;
        }

        foreach ($collectionDataModel as $model) {
            $data[] = $this->getProperties(
                $model,
                $properties,
                $depth,
                $depthLimit
            );
        }

        return $data;
    }

    /**
     * isOverDepthLimit
     *
     * @param $depth
     * @param $depthLimit
     *
     * @return bool
     */
    protected function isOverDepthLimit(
        $depth,
        $depthLimit
    ) {
        // 0 depth = no limit
        if ($depthLimit === 0) {
            return false;
        }

        return ($depth > $depthLimit);
    }

    /**
     * isTraversable
     *
     * @param $dataModel
     *
     * @return bool
     */
    protected function isTraversable($dataModel)
    {
        return (is_array($dataModel) || $dataModel instanceof \Traversable);
    }

    /**
     * getPropertyListProperties
     *
     * @param $dataModel
     *
     * @return array
     */
    protected function getPropertyListFromProperties($dataModel)
    {

        if (is_object($dataModel)) {
            return $this->getPropertyListByMethods($dataModel);
        }

        $properties = [];

        if (!$this->isTraversable($dataModel)) {
            return [];
        }

        foreach ($dataModel as $property => $value) {
            $properties[$property] = true;
        }

        return $properties;
    }

    /**
     * getPropertyListByMethods
     *
     * @param \stdClass|array $dataModel
     *
     * @return array
     */
    protected function getPropertyListByMethods($dataModel)
    {
        $properties = [];

        if (!is_object($dataModel)) {
            return $properties;
        }

        $methods = get_class_methods(get_class($dataModel));

        foreach ($methods as $method) {

            $prefixLen = strlen(self::METHOD_PREFIX);
            if (substr($method, 0, $prefixLen) === self::METHOD_PREFIX) {
                $property = lcfirst(substr($method, $prefixLen));
                $properties[$property] = true;
            }

            $prefixLen = strlen(self::METHOD_BOOL_PREFIX);
            if (substr($method, 0, $prefixLen) === self::METHOD_BOOL_PREFIX) {
                $property = lcfirst(substr($method, $prefixLen));
                $properties[$property] = true;
            }
        }

        return $properties;
    }
}

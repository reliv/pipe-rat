<?php

namespace Reliv\PipeRat\Extractor;

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
     * @param mixed   $object
     * @param Options $options
     *
     * @return array
     */
    public function extract($object, Options $options)
    {
        $properties = $this->getPropertyList($options);
        $depthLimit = $this->getPropertyDepthLimit($options, -1);

        return $this->getProperties($object, $properties, 0, $depthLimit);
    }

    /**
     * getProperties
     *
     * @param \stdClass $object
     * @param array     $properties
     * @param int       $depth
     * @param int       $depthLimit
     *
     * @return array
     */
    protected function getProperties(
        $object,
        array $properties,
        $depth,
        $depthLimit
    ) {
        $data = [];

        if ($this->isOverDepthLimit($depth, $depthLimit)) {
            return $data;
        }

        foreach ($properties as $property => $value) {

            if ($value === false) {
                continue;
            }

            $method = self::METHOD_PREFIX . ucfirst($property);

            if (method_exists($object, $method)) {
                $data[$property] = $object->$method();
            }

            $methodBool = self::METHOD_BOOL_PREFIX . ucfirst($property);

            if (method_exists($object, $methodBool)) {
                $data[$property] = $object->$methodBool();
            }

            if (is_array($value)) {
                $data[$property] = $this->getCollectionProperties(
                    $data[$property],
                    $value,
                    $depth,
                    $depthLimit + 1
                );
            }
        }

        return $data;
    }

    /**
     * getCollectionProperties
     *
     * @param array|\Traversable $collection
     * @param array              $properties
     * @param int                $depth
     * @param int                $depthLimit
     *
     * @return array
     * @throws ExtractorException
     */
    protected function getCollectionProperties(
        $collection,
        array $properties = [],
        $depth,
        $depthLimit
    ) {
        if (!$this->isTraversable($collection)) {
            throw new ExtractorException('Properties are not traversable');
        }

        $data = [];
        if ($this->isOverDepthLimit($depth, $depthLimit)) {
            return $data;
        }

        foreach ($collection as $model) {
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
        if ($depthLimit === -1) {
            return false;
        }

        return ($depth < $depthLimit);
    }

    /**
     * isTraversable
     *
     * @param $value
     *
     * @return bool
     */
    protected function isTraversable($value)
    {
        return (is_array($value) || $value instanceOf \Traversable);
    }
}

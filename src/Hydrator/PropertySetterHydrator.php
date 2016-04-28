<?php

namespace Reliv\PipeRat\Hydrator;

use Reliv\PipeRat\Options\Options;

/**
 * Class PropertySetterHydrator
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class PropertySetterHydrator extends AbstractHydrator implements Hydrator
{
    /**
     * const
     */
    const METHOD_PREFIX = 'set';

    /**
     * hydrate
     *
     * @param array   $data
     * @param mixed   $object
     * @param Options $options
     *
     * @return mixed
     */
    public function hydrate(array $data, $object, Options $options)
    {
        $properties = $this->getPropertyList($options, null);

        // If no properties are set, we get them all if we can
        if (!is_array($properties)) {
            return $this->setByMethods($data, $object);
        }

        $this->setProperties($data, $object, $properties);
    }

    /**
     * setByMethods
     *
     * @param $object
     *
     * @return array
     */
    protected function setByMethods(
        array $data,
        $object
    ) {
        $methods = get_class_methods(get_class($object));

        foreach ($methods as $method) {

            $prefixLen = strlen(self::METHOD_PREFIX);
            if (substr($method, 0, strlen($prefixLen)) === self::METHOD_PREFIX) {
                $property = lcfirst(substr($method, $prefixLen));
                $object->$method($data[$property]);
            }
        }

        return $data;
    }

    /**
     * setProperties
     *
     * @param array $data
     * @param       $object
     * @param array $properties
     *
     * @return void
     */
    protected function setProperties(
        array $data,
        $object,
        array $properties
    ) {
        foreach ($properties as $property => $value) {

            if ($value === false) {
                continue;
            }

            $method = self::METHOD_PREFIX . ucfirst($property);

            if (method_exists($object, $method)) {
                $object->$method($data[$property]);
            }
        }
    }
}

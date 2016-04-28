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
        $properties = $this->getPropertyList($options);

        return $this->setProperties($object, $properties);
    }

    /**
     * getProperties
     *
     * @param \stdClass $object
     * @param array     $properties
     *
     * @return array
     */
    protected function setProperties(
        $object,
        array $properties
    ) {
        $data = [];

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

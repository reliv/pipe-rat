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
class CollectionPropertyGetterExtractor extends PropertyGetterExtractor implements Extractor
{
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

        return $this->getCollectionProperties($object, $properties, 0, $depthLimit);
    }
}

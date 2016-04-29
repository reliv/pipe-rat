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
     * @param array|\Traversable $collectionDataModel
     * @param Options            $options
     *
     * @return array
     */
    public function extract($collectionDataModel, Options $options)
    {
        $properties = $this->getPropertyList($options);

        $depthLimit = $this->getPropertyDepthLimit($options, -1);

        return $this->getCollectionProperties($collectionDataModel, $properties, 0, $depthLimit);
    }
}

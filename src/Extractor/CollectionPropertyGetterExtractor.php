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
        $properties = $this->getPropertyList($options, null);

        // If no properties are set, we get them all if we can
        if (!is_array($properties)) {
            $properties = $this->getPropertyListByCollectionMethods($collectionDataModel);
        }

        $depthLimit = $this->getPropertyDepthLimit($options, 1);

        return $this->getCollectionProperties($collectionDataModel, $properties, 1, $depthLimit);
    }

    /**
     * getPropertyListByCollectionMethods
     *
     * @param \stdClass|array $collectionDataModel
     *
     * @return array
     */
    protected function getPropertyListByCollectionMethods($collectionDataModel)
    {
        $dataModel = null;

        foreach ($collectionDataModel as $ldataModel) {
            $dataModel = $ldataModel;
            break;
        }

        return $this->getPropertyListByMethods($dataModel);
    }
}

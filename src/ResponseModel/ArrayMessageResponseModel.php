<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class ArrayMessageResponseModel
 *
 * API array message format
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\RcmApiLib\Message
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright ${YEAR} Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ArrayMessageResponseModel extends MessageResponseModel
{
    /**
     * @param array $properties
     * @param array $ignore
     */
    public function __construct(
        $properties = [],
        $ignore = []
    ) {
        $this->build(
            $properties,
            $ignore
        );
    }

    protected function build(
        $properties = [],
        $ignore = []
    ) {
        if (!isset($properties['value'])) {
            $properties['value'] = '';
        }

        parent::populate($properties, $ignore);
    }
}

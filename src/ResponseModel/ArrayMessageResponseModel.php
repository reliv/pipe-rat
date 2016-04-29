<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class ArrayMessageResponseModel
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ResponseModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ArrayMessageResponseModel extends MessageResponseModel
{
    /**
     * ArrayMessageResponseModel constructor.
     *
     * @param array $data
     */
    public function __construct(
        $data = []
    ) {
        $this->build(
            $data
        );
    }

    /**
     * build
     *
     * @param array $data
     *
     * @return void
     */
    protected function build(
        $data = []
    ) {
        if (!isset($data['value'])) {
            $data['value'] = '';
        }

        parent::setAllProperties($data);
    }
}

<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class MessageParam
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface MessageParam
{
    /**
     * getMessageParams
     *
     * @return array
     */
    public function getMessageParams();

    /**
     * setMessageParams
     *
     * @param $messageParams ['key' => 'value']
     *
     * @return void
     */
    public function setMessageParams(array $messageParams);
}

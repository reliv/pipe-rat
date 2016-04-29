<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class AbstractMessageParam
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ResponseModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class AbstractMessageParam
{
    /**
     * @var array
     */
    protected $messageParams = [];

    /**
     * getMessageParams
     *
     * @return array
     */
    public function getMessageParams()
    {
        return $this->messageParams;
    }

    /**
     * setMessageParams
     *
     * @param $messageParams ['key' => 'value']
     *
     * @return void
     */
    public function setMessageParams(array $messageParams)
    {
        $this->messageParams = $messageParams;
    }
}

<?php

namespace Reliv\RcmApiLib\InputFilter;

use Zend\InputFilter\InputFilter;

/**
 * Class ZfInputFilterMessageParam
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
class ZfInputFilterMessageParam extends InputFilter implements MessageParamInterface
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

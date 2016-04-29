<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class ValidatorMessageResponseModel
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
class ValidatorMessageResponseModel extends MessageResponseModel
{
    /**
     * @var string type for fields
     */
    protected $typeName = 'validatorMessage';

    /**
     * @param string $validatorMessage
     * @param string $fieldName
     * @param null   $errorKey
     * @param array  $params
     * @param null   $primary
     */
    public function __construct(
        $validatorMessage,
        $fieldName,
        $errorKey,
        $params = [],
        $primary = null
    ) {
        $this->setType($this->typeName);
        $this->setValue($validatorMessage);
        $this->setSource($fieldName);
        $this->setCode($errorKey);
        $this->setPrimary($primary);
        $this->setParams($params);
    }
}

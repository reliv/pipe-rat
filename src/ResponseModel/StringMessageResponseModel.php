<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class StringMessageResponseModel
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
class StringMessageResponseModel extends MessageResponseModel
{
    /**
     * @param string    $message
     * @param string    $type
     * @param string    $source
     * @param string    $code
     * @param null|bool $primary
     * @param array     $params
     */
    public function __construct(
        $message,
        $type = 'generic',
        $source = 'unknown',
        $code = 'fail',
        $primary = null,
        $params = []
    ) {
        parent::__construct(
            $type,
            $message,
            $source,
            $code,
            $primary,
            $params
        );
    }
}

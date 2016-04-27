<?php

namespace Reliv\PipeRat\ResponseModel;

use Reliv\RcmApiLib\Http\ApiResponse;

/**
 * Class MessageResponseModel
 *
 * API message format
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

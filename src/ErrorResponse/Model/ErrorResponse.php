<?php

namespace Reliv\PipeRat\ErrorResponse\Model;

/**
 * Interface ErrorResponse
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
interface ErrorResponse extends \JsonSerializable
{
    /**
     * getError
     *
     * @return Error
     */
    public function getError(): Error;
}

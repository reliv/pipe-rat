<?php

namespace Reliv\PipeRat\ErrorResponse\Model;

/**
 * Class BasicErrorResponse
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class BasicErrorResponse implements ErrorResponse
{
    /**
     * @var Error
     */
    protected $error;

    /**
     * Constructor.
     *
     * @param Error $error
     */
    public function __construct(Error $error)
    {
        $this->error = $error;
    }

    /**
     * getError
     *
     * @return Error
     */
    public function getError(): Error
    {
        return $this->error;
    }

    /**
     * jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}

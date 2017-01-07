<?php

namespace Reliv\PipeRat\ZfInputFilter\Model;

/**
 * Class FieldError
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class FieldError implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $field = '';

    /**
     * @var string
     */
    protected $code = '';

    /**
     * Constructor.
     *
     * @param string $field
     * @param string $message
     * @param string $code
     */
    public function __construct(
        $field,
        $message,
        $code
    ) {
        $this->setField($field);
        $this->setMessage($message);
        $this->setCode($code);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = (string)$field;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = (string)$code;
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

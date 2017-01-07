<?php

namespace Reliv\PipeRat\ErrorResponse\Model;

/**
 * Class AbstractErrorResponse
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
abstract class AbstractError implements Error
{
    /**
     * The name or Category of the message
     *
     * @var string
     */
    protected $name;

    /**
     * A failure code relating to this message
     *
     * @var string|null
     */
    protected $code = null;

    /**
     * The message message
     *
     * @var string
     */
    protected $message;

    /**
     * Extra details related to error
     *
     * @var array
     */
    protected $details = [];

    /**
     * Constructor.
     *
     * @param string $name
     * @param string $message
     * @param null   $code
     * @param array  $details
     */
    public function __construct(
        $name,
        $message = '',
        $code = null,
        $details = []
    ) {
        $this->setName($name);
        $this->setMessage($message);
        $this->setCode($code);
        $this->setDetails($details);
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = lcfirst((string)$name);
    }

    /**
     * getCode
     *
     * @return null|string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * setCode
     *
     * @param string $code
     *
     * @return void
     */
    public function setCode($code)
    {
        if ($code !== null) {
            $code = lcfirst((string)$code);
        }
        $this->code = $code;
    }

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * setMessage
     *
     * @param $message
     *
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = (string)$message;
    }

    /**
     * setDetails
     *
     * @param array $details
     *
     * @return void
     */
    public function setDetails(array $details)
    {
        $this->details = $details;
    }

    /**
     * getDetails
     *
     * @return array
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * getDetail
     *
     * @param string $key
     * @param null   $default
     *
     * @return null|mixed
     */
    public function getDetail($key, $default = null)
    {
        $key = (string)$key;
        if (isset($this->details[$key])) {
            return $this->details[$key];
        }

        return $default;
    }

    /**
     * setDetail
     *
     * @param string $key
     * @param mixed  $message
     *
     * @return void
     */
    public function setDetail($key, $message)
    {
        $key = (string)$key;
        $this->details[$key] = $message;
    }

    /**
     * jsonSerialize
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $array = get_object_vars($this);

        return $array;
     }
}

<?php

namespace Reliv\PipeRat\ErrorResponse\Model;

/**
 * Interface Error
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
interface Error extends \JsonSerializable
{
    /**
     * getName
     *
     * @return string
     */
    public function getName();

    /**
     * setName
     *
     * @param string $name
     *
     * @return void
     */
    public function setName($name);

    /**
     * getStatus
     *
     * @return int|string
     */
    public function getCode();

    /**
     * setCode
     *
     * @param string $code
     *
     * @return void
     */
    public function setCode($code);

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage();

    /**
     * setMessage
     *
     * @param $message
     *
     * @return void
     */
    public function setMessage($message);

    /**
     * setDetails
     *
     * @param array $details
     *
     * @return void
     */
    public function setDetails(array $details);

    /**
     * getDetails
     *
     * @return array
     */
    public function getDetails();

    /**
     * getDetail
     *
     * @param string $key
     * @param null   $default
     *
     * @return null|mixed
     */
    public function getDetail($key, $default = null);

    /**
     * setDetail
     *
     * @param string $key
     * @param mixed  $message
     *
     * @return void
     */
    public function setDetail($key, $message);
}

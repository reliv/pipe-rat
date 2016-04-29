<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class MessageResponseModels
 *
 * LongDescHere
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ResponseModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */

class MessageResponseModels extends AbstractResponseModel implements \IteratorAggregate
{

    /**
     * @var array
     */
    protected $messages = [];

    /**
     * add
     *
     * @param MessageResponseModel $messageResponseModel
     *
     * @return void
     */
    public function add(MessageResponseModel $messageResponseModel)
    {
        $index = $this->getIndex($messageResponseModel->getKey());

        if ($index !== null) {
            unset($this->messages[$index]);
        }

        if ($messageResponseModel->isPrimary()) {
            array_unshift($this->messages, $messageResponseModel);

            return;
        }

        $this->messages[] = $messageResponseModel;
    }

    /**
     * get
     *
     * @param string $key
     * @param null   $default
     *
     * @return null|MessageResponseModel
     */
    public function get($key, $default = null)
    {
        $key = (string)$key;

        $index = $this->getIndex($key);

        if ($index !== null) {
            return $this->messages[$index];
        }

        return $default;
    }

    /**
     * has
     *
     * @return bool
     */
    public function has()
    {
        return (count($this->messages) > 0);
    }

    /**
     * getIndex
     *
     * @param $key
     *
     * @return int|null
     */
    protected function getIndex($key)
    {
        foreach ($this->messages as $index => $messageResponseModel) {
            if ($messageResponseModel->getKey() === $key) {
                return $index;
            }
        }

        return null;
    }

    /**
     * getIterator
     *
     * @return array
     */
    public function getIterator()
    {
        return new \ArrayIterator(array_values($this->messages));
    }
}

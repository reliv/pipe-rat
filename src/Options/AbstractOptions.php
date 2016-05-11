<?php

namespace Reliv\PipeRat\Options;

/**
 * Class AbstractOptions
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class AbstractOptions
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * BasicOptions constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setFromArray($options);
    }

    /**
     * setFromArray
     *
     * @param array $options
     *
     * @return void
     */
    public function setFromArray(array $options)
    {
        foreach ($options as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * get
     *
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            return $this->options[$key];
        }

        return $default;
    }

    /**
     * set
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function set($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * has
     *
     * @param string $key
     *
     * @return mixed
     */
    public function has($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * merge
     *
     * @param Options $options
     *
     * @return void
     */
    public function merge(Options $options)
    {
        $this->setFromArray($options->_toArray());
    }

    /**
     * getOptions
     *
     * @param string $key
     *
     * @return Options
     */
    public function getOptions($key)
    {
        $options = $this->get($key, []);

        if (is_subclass_of($options, 'Reliv\PipeRat\Options')) {
            return $options;
        }

        if (!is_array($options)) {
            $options = [];
            $options[$key] = $options;
        }

        return new BasicOptions($options);
    }

    /**
     * _toArray
     *
     * @return array
     */
    public function _toArray()
    {
        return $this->options;
    }
}

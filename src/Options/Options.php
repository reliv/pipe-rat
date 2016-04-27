<?php

namespace Reliv\PipeRat\Options;

/**
 * interface Options
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
interface Options
{
    /**
     * setFromArray
     *
     * @param array $options
     *
     * @return void
     */
    public function setFromArray(array $options);

    /**
     * get
     *
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * has
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);
    
    /**
     * set
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function set($key, $value);

    /**
     * merge
     * - New options take precedence over local options
     *
     * @param Options $options
     *
     * @return void
     */
    public function merge(Options $options);

    /**
     * getOptions
     *
     * @param string $key
     *
     * @return Options
     */
    public function getOptions($key);

    /**
     * _toArray
     *
     * @return array
     */
    public function _toArray();
}

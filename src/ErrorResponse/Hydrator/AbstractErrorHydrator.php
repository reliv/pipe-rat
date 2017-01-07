<?php

namespace Reliv\PipeRat\ErrorResponse\Hydrator;

/**
 * Class AbstractErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
abstract class AbstractErrorHydrator implements ErrorHydrator
{
    /**
     * getOption
     *
     * @param array  $options
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    protected function getOption(array $options, $key, $default = null)
    {
        if (array_key_exists($key, $options)) {
            return $options[$key];
        }

        return $default;
    }
}

<?php

namespace Reliv\PipeRat\ErrorResponse\Hydrator;

use Reliv\PipeRat\ErrorResponse\Model\Error;

/**
 * Interface ErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
interface ErrorHydrator
{
    /**
     * hydrate
     *
     * @param Error $error
     * @param mixed $data
     * @param array $options
     *
     * @return Error
     */
    public function hydrate(Error $error, $data, array $options = []);
}

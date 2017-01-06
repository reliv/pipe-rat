<?php

namespace Reliv\PipeRat\ErrorResponse\Hydrator;

use Reliv\PipeRat\ErrorResponse\Exception\ErrorResponseException;
use Reliv\PipeRat\ErrorResponse\Model\Error;

/**
 * Class StringErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class StringErrorHydrator extends AbstractErrorHydrator implements ErrorHydrator
{
    /**
     * hydrate
     *
     * @param Error $error
     * @param mixed $data
     * @param array $options
     *
     * @return Error
     * @throws ErrorResponseException
     */
    public function hydrate(Error $error, $data, array $options = [])
    {
        if (!is_string($data)) {
            throw new ErrorResponseException('Data must be message (string)');
        }

        $error->setMessage($data);

        return $error;
    }
}

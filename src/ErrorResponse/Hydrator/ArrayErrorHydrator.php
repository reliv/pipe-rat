<?php

namespace Reliv\PipeRat\ErrorResponse\Hydrator;

use Reliv\PipeRat\ErrorResponse\Exception\ErrorResponseException;
use Reliv\PipeRat\ErrorResponse\Model\Error;

/**
 * Class ArrayErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class ArrayErrorHydrator extends AbstractErrorHydrator implements ErrorHydrator
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
        if (!is_array($data)) {
            throw new ErrorResponseException('Data must be array');
        }

        foreach ($data as $property => $value) {
            $setter = 'set' . ucfirst($property);

            if (!method_exists($error, $setter)) {
                continue;
            }

            $error->$setter($value);
        }

        return $error;
    }
}

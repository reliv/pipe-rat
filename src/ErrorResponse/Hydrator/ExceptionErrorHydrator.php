<?php

namespace Reliv\PipeRat\ErrorResponse\Hydrator;

use Reliv\PipeRat\ErrorResponse\Exception\ErrorResponseException;
use Reliv\PipeRat\ErrorResponse\Model\Error;
use Reliv\PipeRat\ErrorResponse\Model\ExceptionError;

/**
 * Class ExceptionErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class ExceptionErrorHydrator extends AbstractErrorHydrator implements ErrorHydrator
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
        if (!$data instanceof \Exception) {
            throw new ErrorResponseException('Data must be instance of ' . \Exception::class);
        }

        $exception = $data;

        $code = $exception->getCode();

        if (empty($code)) {
            $code = null;
        }

        $error->setName(ExceptionError::NAME);
        $error->setMessage($exception->getMessage());
        $error->getDetail('exception', $this->getSourceString($exception));
        $error->setCode($code);

        return $error;
    }

    /**
     * getSourceString
     *
     * @param $exception
     *
     * @return string
     */
    public function getSourceString(\Exception $exception)
    {
        $className = get_class($exception);
        if ($pos = strrpos($className, '\\')) {
            $className = lcfirst(substr($className, $pos + 1));
        }

        return $className;
    }
}

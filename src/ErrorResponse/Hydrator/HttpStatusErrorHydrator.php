<?php

namespace Reliv\PipeRat\ErrorResponse\Hydrator;

use Reliv\PipeRat\ErrorResponse\Exception\ErrorResponseException;
use Reliv\PipeRat\ErrorResponse\Model\Error;
use Reliv\PipeRat\Http\StatusCodes;

/**
 * Class HttpStatusErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class HttpStatusErrorHydrator extends ArrayErrorHydrator implements ErrorHydrator
{
    /**
     * buildMessage
     *
     * @param array $data
     *
     * @return string
     */
    protected function buildMessage(array $data)
    {
        if (array_key_exists('message', $data)) {
            return $data['message'];
        }

        $status = $this->buildStatus($data);

        return StatusCodes::getReasonPhrase($status);
    }

    /**
     * buildStatus
     *
     * @param array $data
     *
     * @return int
     */
    protected function buildStatus(array $data)
    {
        if (array_key_exists('status', $data)) {
            return (int)$data['status'];
        }

        return StatusCodes::DEFAULT_CODE;
    }

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
        $error = parent::hydrate($error, $data, $options);

        $error->setMessage(
            $this->buildMessage($data)
        );

        $error->setDetail('status', $this->buildStatus($data));

        return $error;
    }
}

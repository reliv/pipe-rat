<?php

namespace Reliv\PipeRat\ZfInputFilter\Hydrator;

use Reliv\PipeRat\ErrorResponse\Exception\ErrorResponseException;
use Reliv\PipeRat\ErrorResponse\Hydrator\AbstractErrorHydrator;
use Reliv\PipeRat\ErrorResponse\Hydrator\ErrorHydrator;
use Reliv\PipeRat\ErrorResponse\Model\Error;
use Reliv\PipeRat\ZfInputFilter\Model\FieldError;
use Reliv\PipeRat\ZfInputFilter\Model\InputFilterError;
use Reliv\PipeRat\ZfInputFilter\Service\FieldErrorsFactory;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ZfInputFilterErrorHydrator
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class ZfInputFilterErrorHydrator extends AbstractErrorHydrator implements ErrorHydrator
{
    /**
     * @var FieldErrorsFactory
     */
    protected $fieldErrorsFactory;

    /**
     * Constructor.
     *
     * @param FieldErrorsFactory $fieldErrorsFactory
     */
    public function __construct(
        FieldErrorsFactory $fieldErrorsFactory
    ) {
        $this->fieldErrorsFactory = $fieldErrorsFactory;
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
        if (!$data instanceof InputFilterInterface) {
            throw new ErrorResponseException('Data must be instance of ' . InputFilterInterface::class);
        }

        $error->setName(
            $this->getOption(
                $options,
                'name',
                InputFilterError::NAME
            )
        );

        $error->setMessage(
            $this->getOption(
                $options,
                'message',
                InputFilterError::MESSAGE
            )
        );

        $error->setCode(
            $this->getOption(
                $options,
                'code',
                InputFilterError::CODE
            )
        );

        $errors = $this->fieldErrorsFactory->build($data);

        $error->setDetail(InputFilterError::DETAIL_FIELD_ERROR_NAME, $errors);

        return $error;
    }
}

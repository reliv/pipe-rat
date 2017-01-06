<?php

namespace Reliv\PipeRat\ZfInputFilter\Model;

use Reliv\PipeRat\ErrorResponse\Model\AbstractError;
use Reliv\PipeRat\ErrorResponse\Model\Error;

/**
 * Class InputFilterError
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class InputFilterError extends AbstractError implements Error
{
    const NAME = 'inputFilter';

    const MESSAGE = 'An Error Occurred';

    const SOURCE = 'validation';

    const CODE = 'error';

    const DETAIL_FIELD_ERROR_NAME = 'fieldErrors';

    /**
     * Constructor.
     *
     * @param string $message
     * @param string $code
     * @param array  $details
     */
    public function __construct(
        $message = self::MESSAGE,
        $code = self::CODE,
        array $details = []
    ) {
        parent::__construct(
            self::NAME,
            $message,
            $code,
            $details
        );
    }
}

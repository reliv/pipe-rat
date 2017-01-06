<?php

namespace Reliv\PipeRat\ErrorResponse\Model;

/**
 * Class ExceptionError
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class ExceptionError extends AbstractError
{
    const NAME = 'exception';

    /**
     * Constructor.
     *
     * @param string $message
     * @param string $code
     * @param array  $details
     */
    public function __construct(
        $message,
        $code,
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

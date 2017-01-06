<?php

namespace Reliv\PipeRat\ErrorResponse\Model;

/**
 * Class StringError
 *
 * @author    James Jervis
 * @license   License.txt
 * @link      https://github.com/jerv13
 */
class StringError extends AbstractError
{
    const NAME = 'generic-message';

    const CODE = 'fail';

    /**
     * Constructor.
     *
     * @param string $message
     * @param string $name
     * @param string $code
     * @param array  $details
     */
    public function __construct(
        $message,
        $name = self::NAME,
        $code = self::CODE,
        array $details = []
    ) {
        parent::__construct(
            $name,
            $message,
            $code,
            $details
        );
    }
}

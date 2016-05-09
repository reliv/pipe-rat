<?php

namespace Reliv\PipeRat\RequestAttribute;

/**
 * Class MiddlewareOptions
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class MiddlewareOptions implements RequestAttribute
{
    /**
     * Request Attribute Id
     */
    const ATTRIBUTE_NAME = 'pipe-rat-middleware-options';

    /**
     * getName
     *
     * @return string
     */
    public static function getName()
    {
        return self::ATTRIBUTE_NAME;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getAttributeName()
    {
        return self::getName();
    }
}

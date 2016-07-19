<?php

namespace Reliv\PipeRat\RequestAttribute;

/**
 * Class Paths
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class Paths implements RequestAttribute
{
    /**
     * Request Attribute Name
     */
    const ATTRIBUTE_NAME = 'pipe-rat-resource-paths';

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

<?php

namespace Reliv\PipeRat\RequestAttribute;

use Reliv\PipeRat\Options\AbstractOptions;
use Reliv\PipeRat\Options\Options;

/**
 * Class RouteParams
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ResourceKey
{
    /**
     * Request Attribute Name
     */
    const ATTRIBUTE_NAME = 'pipe-rat-resource-key';

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

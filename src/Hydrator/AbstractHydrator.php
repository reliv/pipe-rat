<?php

namespace Reliv\PipeRat\Hydrator;

use Reliv\PipeRat\Options\Options;

/**
 * Class AbstractHydrator
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class AbstractHydrator
{
    /**
     * getPropertyList
     *
     * @param Options $options
     * @param array   $default
     *
     * @return array
     */
    public function getPropertyList(Options $options, $default = [])
    {
        return $options->get('propertyList', $default);
    }

    /**
     * getPropertyDepthLimit
     *
     * @param Options $options
     * @param int     $default
     *
     * @return int
     */
    public function getPropertyDepthLimit(Options $options, $default = 1)
    {
        return (int) $options->get('propertyDepthLimit', $default);
    }
}

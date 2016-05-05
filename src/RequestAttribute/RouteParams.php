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
class RouteParams extends AbstractOptions implements Options, RequestAttribute
{
    /**
     * Request Attribute Name
     */
    const ATTRIBUTE_NAME = 'pipe-rat-route-params';

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
     * BasicRouteParams constructor.
     *
     * @param array $routeParams
     */
    public function __construct(array $routeParams = [])
    {
        parent::__construct($routeParams);
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

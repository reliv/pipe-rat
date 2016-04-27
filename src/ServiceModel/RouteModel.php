<?php

namespace Reliv\PipeRat\ServiceModel;

/**
 * Interface RouteModel
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
interface RouteModel extends ServiceModelCollection
{
    /**
     * Request Attribute Id
     */
    const REQUEST_ATTRIBUTE_MODEL_ROUTE = 'api-lib-resource-model-route';

    /**
     * setRouteParam
     *
     * @param string $param
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setRouteParam($param, $value);

    /**
     * getRouteParam
     *
     * @param string $param
     * @param null   $default
     *
     * @return mixed
     */
    public function getRouteParam($param, $default = null);

    /**
     * hasRouteParam
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasRouteParam($param);

    /**
     * hasRouteParams
     *
     * @return bool
     */
    public function hasRouteParams();
}

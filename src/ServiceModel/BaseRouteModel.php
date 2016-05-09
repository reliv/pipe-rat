<?php

namespace Reliv\PipeRat\ServiceModel;

/**
 * @deprecated
 * Class BaseRouteModel
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class BaseRouteModel extends AbstractServiceModelCollection implements RouteModel
{
    /**
     * @var array
     */
    protected $routeParams = [];

    /**
     * setRouteParam
     *
     * @param string $param
     * @param mixed  $value
     *
     * @return mixed
     */
    public function setRouteParam($param, $value)
    {
        $this->routeParams[$param] = $value;
    }

    /**
     * getRouteParam
     *
     * @param string $param
     * @param null   $default
     *
     * @return mixed
     */
    public function getRouteParam($param, $default = null)
    {
        if ($this->hasRouteParam($param)) {
            return $this->routeParams[$param];
        }

        return $default;
    }

    /**
     * hasRouteParam
     *
     * @param string $param
     *
     * @return bool
     */
    public function hasRouteParam($param)
    {
        return array_key_exists($param, $this->routeParams);
    }

    /**
     * hasRouteParams
     *
     * @return bool
     */
    public function hasRouteParams()
    {
        return !empty($this->routeParams);
    }
}

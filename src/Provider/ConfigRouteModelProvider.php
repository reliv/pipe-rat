<?php

namespace Reliv\PipeRat\Provider;

use Reliv\PipeRat\ServiceModel\BaseRouteModel;
use Reliv\PipeRat\ServiceModel\RouteModel;

/**
 * class ConfigRouteModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ConfigRouteModelProvider extends ConfigAbstractModelProvider implements ModelProvider
{
    /**
     * @var RouteModel
     */
    protected $routerModel;

    /**
     * get
     *
     * @return RouteModel
     */
    public function get()
    {
        if (empty($this->routerModel)) {
            $services = $this->buildServiceArray(
                $this->config['Reliv\\PipeRat']['routeServiceNames']
            );
            $servicesOptions = $this->buildOptionArray(
                $this->config['Reliv\\PipeRat']['routeServiceOptions']
            );
            $servicePriorities = $this->buildOptionArray(
                $this->config['Reliv\\PipeRat']['routeServicePriority']
            );
            $this->routerModel = new BaseRouteModel(
                $services,
                $servicesOptions,
                $servicePriorities
            );
        }

        return $this->routerModel;
    }
}

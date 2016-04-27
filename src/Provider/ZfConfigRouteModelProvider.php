<?php

namespace Reliv\PipeRat\Provider;

use Reliv\PipeRat\ServiceModel\BaseRouteModel;
use Reliv\PipeRat\ServiceModel\RouteModel;
use Reliv\PipeRat\Options\GenericOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * class ZfConfigRouteModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfConfigRouteModelProvider extends ZfConfigAbstractModelProvider implements ModelProvider
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
                $this->config['Reliv\\RcmApiLib']['resource']['routeServiceNames']
            );
            $servicesOptions = $this->buildOptionArray(
                $this->config['Reliv\\RcmApiLib']['resource']['routeServiceOptions']
            );
            $servicePriorities = $this->buildOptionArray(
                $this->config['Reliv\\RcmApiLib']['resource']['routeServicePriority']
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

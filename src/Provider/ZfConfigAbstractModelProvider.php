<?php

namespace Reliv\PipeRat\Provider;

use Reliv\PipeRat\ServiceModel\BaseRouteModel;
use Reliv\PipeRat\ServiceModel\RouteModel;
use Reliv\PipeRat\Options\GenericOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * class ZfConfigAbstractModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class ZfConfigAbstractModelProvider
{
    /**
     * @var array
     */
    protected $config;
    
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;
    
    /**
     * ConfigRouteModelProvider constructor.
     *
     * @param array $config
     * @param ServiceLocatorInterface $serviceManager
     */
    public function __construct(
        $config,
        ServiceLocatorInterface $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
        $this->config = $config;
    }

    /**
     * buildServiceArray
     *
     * @param $serviceNames
     *
     * @return array
     */
    protected function buildServiceArray($serviceNames)
    {
        $services = [];
        foreach ($serviceNames as $serviceAlias => $serviceName) {
            $services[$serviceAlias] = $this->serviceManager->get($serviceName);
        }

        return $services;
    }

    /**
     * buildOptionArray
     *
     * @param $optionsArrays
     *
     * @return array
     */
    protected function buildOptionArray($optionsArrays)
    {
        $serviceOptions = [];
        foreach ($optionsArrays as $serviceAlias => $serviceOptionsArray) {
            $serviceOptions[$serviceAlias] = new GenericOptions($serviceOptionsArray);
        }

        return $serviceOptions;
    }
}

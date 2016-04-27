<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Reliv\PipeRat\Options\GenericOptions;

/**
 * class ConfigAbstractModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class ConfigAbstractModelProvider
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * ConfigAbstractModelProvider constructor.
     *
     * @param array              $config
     * @param ContainerInterface $serviceManager
     */
    public function __construct(
        $config,
        $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
        $this->config = $config;
    }

    /**
     * buildServiceArray
     *
     * @param array $serviceNames
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

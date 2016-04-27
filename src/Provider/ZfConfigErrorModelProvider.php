<?php

namespace Reliv\PipeRat\Provider;

use Reliv\PipeRat\ServiceModel\BaseErrorModel;
use Reliv\PipeRat\ServiceModel\BaseRouteModel;
use Reliv\PipeRat\ServiceModel\ErrorModel;
use Reliv\PipeRat\ServiceModel\RouteModel;
use Reliv\PipeRat\Options\GenericOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * class ZfConfigErrorModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfConfigErrorModelProvider extends ZfConfigAbstractModelProvider implements ModelProvider
{
    /**
     * @var ErrorModel
     */
    protected $errorModel;

    /**
     * get
     *
     * @return ErrorModel
     */
    public function get()
    {
        if (empty($this->errorModel)) {
            $services = $this->buildServiceArray(
                $this->config['Reliv\\RcmApiLib']['resource']['errorServiceNames']
            );
            // Options cannot be supported
            $servicesOptions = [];

            $servicePriorities = $this->buildOptionArray(
                $this->config['Reliv\\RcmApiLib']['resource']['errorServicePriority']
            );
            $this->errorModel = new BaseErrorModel(
                $services,
                $servicesOptions,
                $servicePriorities
            );
        }

        return $this->errorModel;
    }
}

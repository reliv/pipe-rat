<?php

namespace Reliv\PipeRat\Provider;

use Reliv\PipeRat\ServiceModel\BaseErrorModel;
use Reliv\PipeRat\ServiceModel\ErrorModel;

/**
 * class ConfigErrorModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ConfigErrorModelProvider extends ConfigAbstractModelProvider implements ModelProvider
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
                $this->config['Reliv\\PipeRat']['errorServiceNames']
            );
            // Options cannot be supported
            $servicesOptions = [];

            $servicePriorities = $this->buildOptionArray(
                $this->config['Reliv\\PipeRat']['errorServicePriority']
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

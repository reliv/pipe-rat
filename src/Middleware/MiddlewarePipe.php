<?php

namespace Reliv\PipeRat\Middleware;

use Reliv\PipeRat\ServiceModel\ServiceModelCollection;
use Reliv\PipeRat\Options\Options;

/**
 * Class MiddlewarePipe
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class MiddlewarePipe extends \Zend\Stratigility\MiddlewarePipe
{
    /**
     * pipeServices
     *
     * @param ServiceModelCollection $model
     *
     * @return void
     */
    public function pipeServices(
        ServiceModelCollection $model
    ) {
        $services = $model->getServices();

        // resource controller pre
        foreach ($services as $serviceAlias => $service) {
            $options = $model->getOptions(
                $serviceAlias
            );
            $this->pipeService(
                $service,
                $options
            );
        }
    }

    /**
     * pipeService
     *
     * @param callable $service
     * @param Options  $options
     *
     * @return void
     */
    public function pipeService(
        $service,
        Options $options
    ) {
        $middlewareOptions = new OptionsMiddleware($options);
        $this->pipe($middlewareOptions);
        $this->pipe($service);
    }
}

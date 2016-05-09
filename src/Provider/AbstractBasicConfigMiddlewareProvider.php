<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResourceException;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Reliv\PipeRat\Operation\BasicOperation;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\ResourceKey;

/**
 * Class AbstractConfigMiddlewareProvider
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractBasicConfigMiddlewareProvider extends AbstractMiddlewareProvider
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var
     */
    protected $configOptions;

    /**
     * BasicConfigMiddlewareProvider constructor.
     *
     * @param array              $config
     * @param ContainerInterface $serviceManager
     */
    public function __construct(
        $config,
        $serviceManager
    ) {
        $this->config = $config['Reliv\\PipeRat'];
        parent::__construct($serviceManager);
    }

    /**
     * getConfigOptions
     *
     * @return GenericOptions
     */
    protected function getConfigOptions()
    {
        if(empty($this->configOptions)) {
            $this->configOptions = new GenericOptions($this->config);
        }

        return $this->configOptions;
    }
}

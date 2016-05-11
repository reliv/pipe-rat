<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Reliv\PipeRat\Options\BasicOptions;
use Reliv\PipeRat\Options\Options;

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
     * @var Options
     */
    protected $configOptions;

    /**
     * AbstractBasicConfigMiddlewareProvider constructor.
     *
     * @param array $config
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
     * @return Options
     */
    protected function getConfigOptions()
    {
        if(empty($this->configOptions)) {
            $this->configOptions = new BasicOptions($this->config);
        }

        return $this->configOptions;
    }
}

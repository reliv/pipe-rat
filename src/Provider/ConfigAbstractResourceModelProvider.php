<?php

namespace Reliv\PipeRat\Provider;

use Interop\Container\ContainerInterface;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;

/**
 * Class ConfigAbstractResourceModelProvider
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class ConfigAbstractResourceModelProvider
{
    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * @var Options
     */
    protected $defaultOptions;

    /**
     * @var Options
     */
    protected $resourcesOptions;

    /**
     * ConfigAbstractResourceModelProvider constructor.
     *
     * @param array              $config
     * @param ContainerInterface $serviceManager
     */
    public function __construct(
        $config,
        $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
        $this->defaultOptions = new GenericOptions(
            $config['Reliv\\PipeRat']['defaultResourceConfig']
        );

        $this->resourcesOptions = new GenericOptions(
            $config['Reliv\\PipeRat']['resources']
        );
    }

    /**
     * getResourceValue
     *
     * @param string     $resourceKey
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    protected function getResourceValue($resourceKey, $key, $default = null)
    {
        $resourceOptions = $this->resourcesOptions->getOptions($resourceKey);
        $value = $resourceOptions->get($key, $default);

        return $value;
    }

    /**
     * getDefaultValue
     *
     * @param string     $resourceKey
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    protected function getDefaultValue($resourceKey, $key, $default = null)
    {
        $extendsConfig = $this->getResourceValue($resourceKey, 'extendsConfig', 'default:empty');

        $defaultOptions = $this->defaultOptions->getOptions($extendsConfig);

        return $defaultOptions->get($key, $default);
    }

    /**
     * buildValue
     *
     * @param string $resourceKey
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    protected function buildValue($resourceKey, $key, $default = null)
    {
        $defaultValue = $this->getDefaultValue($resourceKey, $key, $default);

        return $this->getResourceValue($resourceKey, $key, $defaultValue);
    }

    /**
     * buildMergeValue - Merge array values
     *
     * @param string $resourceKey
     * @param string $key
     *
     * @return array
     */
    protected function buildMergeValue($resourceKey, $key)
    {
        $defaultValue = $this->getDefaultValue($resourceKey, $key, []);

        $resourceValue = $this->getResourceValue($resourceKey, $key, []);

        return array_merge($defaultValue, $resourceValue);
    }

    /**
     * buildOptions
     *
     * @param string $resourceKey
     * @param string $key
     *
     * @return GenericOptions
     */
    protected function buildOptions($resourceKey, $key)
    {
        $array = $this->buildValue($resourceKey, $key, []);

        return new GenericOptions($array);
    }
}

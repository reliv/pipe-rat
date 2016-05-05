<?php

namespace Reliv\PipeRat\Provider;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\MiddlewarePipe;
use Interop\Container\ContainerInterface;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;

/**
 * Class BasicConfigMiddlewareProvider
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
class BasicConfigMiddlewareProvider implements MiddlewareProvider
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $resourceConfig;

    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * @var array
     */
    protected $paths = [];

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
        $this->serviceManager = $serviceManager;
        $this->config = $config['Reliv\\PipeRat'];
    }

    /**
     * getResourceConfig
     *
     * @return array|mixed
     */
    protected function getResourceConfig()
    {

        if (!empty($this->resourceConfig)) {
            return $this->resourceConfig;
        }

        $resourceConfig = $this->config['resources'];
        $defaultConfig = $this->config['defaultResourceConfig'];

        foreach ($resourceConfig as $resourceKey => $resourceProperties) {
            $defaultResourcePropertyKey = 'default:empty';
            if (array_key_exists('extendsConfig', $resourceProperties)) {
                $defaultResourcePropertyKey = $resourceProperties['extendsConfig'];
            }

            $resourceConfig = array_merge_recursive(
                $defaultConfig[$defaultResourcePropertyKey],
                $resourceProperties
            );

            $this->resourceConfig[$resourceKey] = new GenericOptions($resourceConfig);
        }

        return $this->resourceConfig;
    }

    /**
     * buildPipe
     *
     * @param MiddlewarePipe $middlewarePipe
     * @param Request        $request
     *
     * @return MiddlewarePipe
     */
    public function buildPipe(
        MiddlewarePipe $middlewarePipe,
        Request $request
    ) {

    }

    /**
     * getResources
     *
     * @return array
     */
    public function getPaths()
    {
        if (!empty($paths)) {
            return $this->paths;
        }

        $resourceConfig = $this->getResourceConfig();

        /**
         * @var         $resourceKey
         * @var Options $resourceOptions
         */
        foreach ($resourceConfig as $resourceKey => $resourceOptions) {
            $resourcePath = $resourceOptions->get('path', '/' . $resourceKey);
            foreach ($resourceOptions->get('methods', []) as $methodName => $methodProperties) {
                $methodOptions = new GenericOptions($methodProperties);

                $resourcePath .= $methodOptions->get('path', '/' . $methodName);

                if (!array_key_exists($resourcePath, $this->paths)) {
                    $this->paths[$resourcePath] = [];
                }

                $this->paths[$resourcePath][$methodOptions->get('httpVerb'] = $resourceKey . ':' . $methodName;
            }
        }

        return $this->paths;

        return [
            '/{path}' => [
                '{verb}' => 'resourceId'
            ],
        ];
    }
}

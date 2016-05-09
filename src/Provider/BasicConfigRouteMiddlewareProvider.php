<?php

namespace Reliv\PipeRat\Provider;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ConfigException;
use Reliv\PipeRat\Operation\BasicOperationCollection;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\Paths;

/**
 * Class BasicConfigRouteMiddlewareProvider
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
class BasicConfigRouteMiddlewareProvider extends BasicConfigMiddlewareProvider implements RouteMiddlewareProvider
{
    /**
     * @var array
     */
    protected $paths = [];

    /**
     * buildResourceOperationCollection
     *
     * @param string $resourceKey
     *
     * @return BasicOperationCollection
     * @throws \Exception
     */
    protected function buildResourceOperationCollection($resourceKey)
    {
        $configOptions = $this->getConfigOptions();

        $operationServiceNames = $configOptions->get('routeServiceNames', []);

        if (empty($operationServiceNames)) {
            throw new ConfigException('routeServiceNames missing in config');
        }

        $operations = new BasicOperationCollection();
        $operationOptions = $configOptions->getOptions('routeServiceOptions');
        $operationPriorities = $configOptions->getOptions('routeServicePriority');

        $this->buildOperations(
            $operations,
            $operationServiceNames,
            $operationOptions,
            $operationPriorities
        );
    }

    /**
     * withPaths
     *
     * set Reliv\PipeRat\RequestAttribute\Paths attribute = array ['/{path}' => ['{verb}' => 'resourceId']]
     *
     * @param Request $request
     *
     * @return Request
     */
    public function withPaths(Request $request)
    {
        if (!empty($this->paths)) {
            $request->withAttribute(Paths::getName(), $this->paths);
            return $request;
        }

        $resourceConfig = $this->getResourceConfig();

        /**
         * @var string  $resourceKey
         * @var Options $resourceOptions
         */
        foreach ($resourceConfig as $resourceKey => $resourceOptions) {
            $resourcePath = $resourceOptions->get('path', '/' . $resourceKey);

            $methodsAllowed = $resourceOptions->get('methodsAllowed', []);
            foreach ($resourceOptions->get('methods', []) as $methodName => $methodProperties) {
                if (!in_array($methodName, $methodsAllowed)) {
                    continue;
                }
                $methodOptions = new GenericOptions($methodProperties);

                $resourcePath .= $methodOptions->get('path', '/' . $methodName);

                if (!array_key_exists($resourcePath, $this->paths)) {
                    $this->paths[$resourcePath] = [];
                }

                $this->paths[$resourcePath][$methodOptions->get('httpVerb', 'GET')] = $resourceKey . ':' . $methodName;
            }
        }

        // Reverse to priority
        $this->paths = array_reverse($this->paths, true);

        return $request->withAttribute(Paths::getName(), $this->paths);
    }
}

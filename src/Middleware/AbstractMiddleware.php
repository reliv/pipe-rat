<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Http\BasicDataResponse;
use Reliv\PipeRat\Http\DataResponse;
use Reliv\PipeRat\Options\GenericOptions;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\RequestAttribute\MiddlewareOptions;
use Reliv\PipeRat\RequestAttribute\ResourceKey;

/**
 * Class AbstractMiddleware
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   MiddlewareInterface
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractMiddleware
{
    /**
     * getResourceKey
     *
     * @param Request $request
     * @param null    $default
     *
     * @return mixed
     */
    protected function getResourceKey(Request $request, $default = null)
    {
        return $request->getAttribute(ResourceKey::getName(), $default);
    }

    /**
     * getOptions
     *
     * @param Request $request
     *
     * @return Options
     */
    protected function getOptions(Request $request)
    {
        /** @var Options $options */
        $options = $request->getAttribute(
            MiddlewareOptions::getName(),
            new GenericOptions()
        );

        return $options;
    }

    /**
     * getOption
     *
     * @param Request    $request
     * @param string     $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    protected function getOption(Request $request, $key, $default = null)
    {
        /** @var Options $options */
        $options = $this->getOptions($request);

        return $options->get($key, $default);
    }

    /**
     * getOption
     *
     * @param Request $request
     * @param string  $key
     *
     * @return mixed
     */
    protected function getOptionAsOptions(Request $request, $key)
    {
        /** @var Options $options */
        $options = $this->getOptions($request);

        if (!$options->has($key)) {
            return new GenericOptions();
        }

        return $options->getOptions($key);
    }

    /**
     * getRequestData
     *
     * @param Request    $request
     * @param mixed|null $default
     *
     * @return mixed
     */
    protected function getRequestData(Request $request, $default = null)
    {
        return $request->getAttribute('dataBody', $default);
    }

    /**
     * getDataModel
     *
     * @param Response   $response
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getDataModel(Response $response, $default = null)
    {
        if ($response instanceof DataResponse) {
            return $response->getDataBody();
        }

        return $default;
    }

    /**
     * getQueryParam
     *
     * @param Request $request
     * @param         $param
     * @param null    $default
     *
     * @return null
     */
    public function getQueryParam(Request $request, $param, $default = null)
    {
        $params = $request->getQueryParams();

        if (array_key_exists($param, $params)) {
            return $params[$param];
        }

        return $default;
    }

    /**
     * withDataResponse
     *
     * @param Response $response
     * @param mixed    $dataModel
     *
     * @return DataResponse
     */
    protected function withDataResponse(Response $response, $dataModel)
    {
        if (!$response instanceof DataResponse) {
            $response = new BasicDataResponse($response);
        }

        return $response->withDataBody($dataModel);
    }
}

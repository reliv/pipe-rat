<?php

namespace Reliv\PipeRat\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Http\BasicDataResponse;
use Reliv\PipeRat\Http\DataResponse;
use Reliv\PipeRat\Options\BasicOptions;
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
            new BasicOptions()
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
            return new BasicOptions();
        }

        return $options->getOptions($key);
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
     * getResponseWithDataBody
     *
     * @param Response $response
     * @param          $dataModel
     *
     * @return \Psr\Http\Message\MessageInterface|Response
     */
    protected function getResponseWithDataBody(Response $response, $dataModel)
    {
        if (!$response instanceof DataResponse) {
            $response = new BasicDataResponse($response);
        }

        return $response->withDataBody($dataModel);
    }
}

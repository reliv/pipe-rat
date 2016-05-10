<?php

namespace Reliv\PipeRat\Middleware\RequestFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Exception\RequestFormatException;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\GenericOptions;

/**
 * Class JsonParamsRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class JsonParamsRequestFormat implements Middleware
{
    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $out
     *
     * @return mixed
     * @throws InvalidWhereException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $params = $request->getQueryParams();

        $jsonParams = [];

        foreach ($params as $key => $value) {
            $jsonParams[$key] = $this->getJsonValue($value);
        }

        $paramsOptions = new GenericOptions($jsonParams);

        $request = $request->withAttribute('jsonParams', $paramsOptions);

        return $out($request, $response);
    }

    /**
     * getJsonValue
     *
     * @param $value
     *
     * @return mixed
     */
    protected function getJsonValue($value)
    {
        $value = trim($value);
        
        if (is_numeric($value)) {
            $value = (float)$value;
        }

        if ($value === 'true') {
            $value = true;
        }

        if ($value === 'false') {
            $value = false;
        }

        if ($value === 'null') {
            $value = null;
        }

        if (!is_string($value)) {
            return $value;
        }

        if (substr($value, 0, 1) === '"' && substr($value, -1, 1) === '"') {
            return $this->jsonDecode($value);
        }

        if (substr($value, 0, 1) === '{' && substr($value, -1, 1) === '}') {
            return $this->jsonDecode($value);
        }

        if (substr($value, 0, 1) === '[' && substr($value, -1, 1) === ']') {
            return $this->jsonDecode($value);
        }

        $value = '"' . $value . '"';

        return $this->jsonDecode($value);
    }

    /**
     * jsonDecode
     *
     * @param $value
     *
     * @return mixed
     * @throws RequestFormatException
     */
    protected function jsonDecode($value)
    {
        $jsonValue = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw  new RequestFormatException('JsonParamsRequestFormat received invalid JSON value: ' . $value);
        }

        return $jsonValue;
    }
}

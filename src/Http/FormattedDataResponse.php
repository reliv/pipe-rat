<?php

namespace Reliv\PipeRat\Http;

use Psr\Http\Message\ResponseInterface;
use Reliv\PipeRat\Options\Options;
use Reliv\PipeRat\Middleware\ResponseFormat\ResponseFormat;

/**
 * Class FormattedDataResponse
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Http
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class FormattedDataResponse extends Response implements DataResponse
{
    /**
     * @var ResponseFormat
     */
    protected $responseFormat;

    /**
     * @var Options
     */
    protected $responseFormatOptions;

    /**
     * @var null
     */
    protected $dataBody = null;

    /**
     * @param ResponseInterface $response
     * @param ResponseFormat    $responseFormat
     */
    public function __construct(
        ResponseInterface $response,
        ResponseFormat $responseFormat,
        Options $responseFormatOptions
    ) {
        $this->responseFormat = $responseFormat;
        $this->responseFormatOptions = $responseFormatOptions;
        parent::__construct(
            $response
        );
    }

    /**
     * withDataBody
     *
     * @param mixed $dataBody
     *
     * @return \Psr\Http\Message\MessageInterface|ResponseInterface
     */
    public function withDataBody($dataBody)
    {
        $this->dataBody = $dataBody;
        //$body = $this->getBody();
        //
        //$dataString = $this->responseFormat->build($data, $this->responseFormatOptions);
        //
        //$body->write($dataString);
        //
        //return $this->withBody($body);
    }

    /**
     * getDataBody
     *
     * @return mixed
     */
    public function getDataBody()
    {
        return $this->dataBody;
    }
}

<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResponseFormatException;
use Reliv\PipeRat\Extractor\Extractor;
use Reliv\PipeRat\Extractor\PropertyGetterExtractor;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\GenericOptions;

/**
 * Class FileDataResponseFormat
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class FileDataResponseFormat extends AbstractResponseFormat implements Middleware
{
    /**
     *
     */
    const DOWNLOAD_HEADER = 'application/octet-stream';

    /**
     * @var PropertyGetterExtractor
     */
    protected $extractor;

    /**
     * FileDataResponseFormat constructor.
     *
     * @param Extractor $extractor
     */
    public function __construct(Extractor $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * @var array
     */
    protected $defaultAcceptTypes = [];

    /**
     * getContentTypeOption
     *
     * @param Request $request
     *
     * @return mixed|string
     */
    protected function getContentType(Request $request, array $properties)
    {
        $options = $this->getOptions($request);

        $downloadQueryParam = $options->get('downloadQueryParam', 'download');

        $isDownload = (bool)$this->getQueryParam($request, $downloadQueryParam, false);

        $contentType = $options->get('contentType', $properties['contentType']);

        $isDownload = ($isDownload || $contentType === self::DOWNLOAD_HEADER);

        if ($isDownload) {
            $contentType = self::DOWNLOAD_HEADER;
            $fileName = $options->get('fileName', $properties['fileName']);

            if (!empty($fileName)) {
                //$response = $response->->withHeader(
                //    'Content-Disposition',
                //    ['attachment', 'filename="' . $fileName . '"']
                //);
            }
        }

        return $contentType;
    }

    /**
     * getProperties
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return array
     * @throws ResponseFormatException
     */
    protected function getProperties(Request $request, Response $response)
    {
        $options = $this->getOptions($request);

        $dataModel = $this->getDataModel($response);

        $fileBase64Property = $options->get('fileBase64Property');

        if (empty($fileBase64Property)) {
            throw new ResponseFormatException('FileDataResponseFormat requires fileBase64Property option to be set');
        }

        $propertyList = [
            $fileBase64Property => true,
        ];

        $fileContentTypeProperty = $options->get('fileContentTypeProperty');

        if (!empty($fileContentTypeProperty)) {
            $propertyList[$fileContentTypeProperty] = true;
        }

        $fileNameProperty = $options->get('fileNameProperty');

        if (!empty($fileNameProperty)) {
            $propertyList[$fileNameProperty] = true;
        }

        $extractorOptions = new GenericOptions(['propertyList' => $propertyList]);

        $properties = $this->extractor->extract($dataModel, $extractorOptions);

        return [
            'file' => base64_decode($this->getProperty($properties, $fileBase64Property)),
            'contentType' => $this->getProperty($properties, $fileContentTypeProperty, self::DOWNLOAD_HEADER),
            'fileName' => $this->getProperty($properties, $fileNameProperty),
        ];
    }

    /**
     * getProperty
     *
     * @param array  $list
     * @param string $key
     * @param null   $default
     *
     * @return null
     */
    protected function getProperty(array $list, $key, $default = null)
    {
        if (array_key_exists($key, $list)) {
            return $list[$key];
        }

        return $default;
    }

    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return \Psr\Http\Message\MessageInterface
     * @throws ResponseFormatException
     */
    public function __invoke(Request $request, Response $response, callable $next = null)
    {
        if (!$this->isValidAcceptType($request)) {
            return $next($request, $response);
        }

        $body = $response->getBody();

        $properties = $this->getProperties($request, $response);

        $body->write($properties['file']);

        $contentType = $this->getContentType($request, $properties);

        $response = $response->withBody($body)->withHeader(
            'Content-Type',
            $contentType
        );

        return parent::__invoke($request, $response, $next);
    }
}

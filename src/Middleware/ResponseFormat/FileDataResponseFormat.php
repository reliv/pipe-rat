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
        $dataModel = $this->getDataModel($response);

        $options = $this->getOptions($request);

        $base64FileProperty = $options->get('base64FileProperty');

        if (empty($base64FileProperty)) {
            throw new ResponseFormatException('FileDataResponseFormat requires base64FileProperty option to be set');
        }

        $extractorOptions = new GenericOptions(['propertyList' => [$base64FileProperty => true]]);

        $base64FileProperties = $this->extractor->extract($dataModel, $extractorOptions);

        if (!array_key_exists($base64FileProperty, $base64FileProperties)) {
            throw new ResponseFormatException('FileDataResponseFormat could not extract base64FileProperty');
        }

        $base64File = $base64FileProperties[$base64FileProperty];

        $fileName = $options->get('fileName', 'file');

        $contentType = $options->get('contentType', 'application/octet-stream');

        $body = $response->getBody();

        $body->write(base64_decode($base64File));

        return $response->withBody($body)->withHeader(
            'Content-Type',
            $contentType
        )->withHeader(
            'Content-Disposition',
            ['attachment', 'filename="' . $fileName . '"']
        );
    }
}

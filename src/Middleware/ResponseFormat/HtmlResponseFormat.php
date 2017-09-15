<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResponseFormatException;
use Reliv\PipeRat\Extractor\Extractor;
use Reliv\PipeRat\Extractor\PropertyGetterExtractor;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\BasicOptions;

/**
 * Class HtmlResponseFormat
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class HtmlResponseFormat extends AbstractResponseFormat implements Middleware
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
    protected $defaultAcceptTypes
        = [
            'text/html',
            'application/xhtml',
        ];

    /**
     * getFormatConfig
     * [
     *  '{property}' => [
     *     'tag' => '{tag}',
     *     'attributes' => ['{name}' => '{value}'],
     *     'content' => '',
     *     'properties' => [
     *       // sub-properties in they exist
     *     ]
     *   ]
     * ]
     *
     * @param Request $request
     *
     * @return array
     */
    protected function getTemplateConfig(Request $request)
    {
        return $this->getOption($request, 'htmlTemplate', []);
    }

    /**
     * getTemplateData
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function getTemplateData(array $templateConfig, array $dataArray)
    {

    }

    /**
     * getFormatProperties
     *
     * @param array $templateConfig
     *
     * @return array
     */
    protected function getFormatProperties(array $templateConfig)
    {
        $propertyList = [];

        foreach ($templateConfig as $property => $config) {
            if (array_key_exists('properties', $config)) {
                $propertyList[$property] = $this->getFormatProperties($config['properties']);
                continue;
            }

            $propertyList[$property] = true;
        }

        return $propertyList;
    }

    /**
     * buildMarkup
     *
     * @param $properties
     * @param $templateConfig
     * @param $containerTag
     * @param $containerAttributes
     *
     * @return void
     */
    protected function buildMarkup($properties, $templateConfig, $containerTag, $containerAttributes)
    {
        $templateConfigOptions = new BasicOptions($templateConfig);

        $markup = '';

        foreach ($properties as $property => $content) {

            if (!$templateConfigOptions->has($property)) {
                continue;
            }

            $templateOptions = $templateConfigOptions->getOptions($property);

            $subTemplateConfig = $templateOptions->get('properties', []);

            if (!empty($subProperties)) {
                $markup = $markup . $this->buildMarkup($subProperties, $subTemplateConfig->get($property));
            }

            $markup = $this->buildTag($content, $templateOptions->get, $attr = []);
        }

        return $this->buildTag($markup, $containerTag, $containerAttributes);
    }

    protected function buildTag($content, $tag, $attr = [])
    {
        $markup = '<' . $tag;

        foreach ($attr as $name => $value) {
            $markup .= ' ' . $name . '="' . $value . '"';
        }
        $markup .= ">\n" . $content;

        $markup .= "\n<" . $tag . "/>\n";

        return $markup;
    }

    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return static
     * @throws ResponseFormatException
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $response = $next($request);

        if (!$this->isFormattableResponse($response)) {
            return $response;
        }

        if (!$this->isValidAcceptType($request)) {
            return $response;
        }

        // @todo finish me
        throw new ResponseFormatException(get_class($this) . ' not ready for use');
        $dataModel = $this->getDataModel($response, null);

        if (!is_array($dataModel)) {
            throw new ResponseFormatException(get_class($this) . ' requires dataModel to be an array');
        }

        $templateConfig = $this->getTemplateConfig($request);

        $propertyList = $this->getFormatProperties($templateConfig);

        $extractorOptions = new BasicOptions(['propertyList' => $propertyList]);

        $properties = $this->extractor->extract($dataModel, $extractorOptions);

        $containerTag = $this->getOption($request, 'containerTag', 'div');

        $containerAttributes = $this->getOption($request, 'containerAttributes', []);

        $body = $response->getBody();

        $content = $this->buildMarkup($properties, $templateConfig, $containerTag, $containerAttributes);

        $body->write($content);

        return $response->withBody($body)->withHeader(
            'Content-Type',
            'text/html'
        );
    }
}

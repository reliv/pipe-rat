<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\ResponseFormatException;
use Reliv\PipeRat\Middleware\Middleware;

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
     * @var array
     */
    protected $defaultAcceptTypes= [
        'text/html',
        'application/xhtml',
    ];

    /**
     * buildMarkup
     *
     * @param string $content
     * @param string $tag
     * @param array  $attr
     *
     * @return string
     */
    protected function buildMarkup($content, $tag, $attr = [])
    {
        $markup = '<' . $tag;

        foreach ($attr as $name => $value) {
            $markup .= ' ' . $name . '="' . $value . '"';
        }
        $markup .= '>' . $content;

        $markup .= '<' . $tag . '/>';

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
        if (!$this->isValidAcceptType($request)) {
            return $next($request, $response);
        }
        $dataModel = $this->getDataModel($response, null);

        if (!is_array($dataModel)) {
            throw new ResponseFormatException(get_class($this) . ' requires dataModel to be an array');
        }

        $containerTag = $this->getOption($request, 'containerTag', 'div');

        $body = $response->getBody();
        $content = $body->getContents();
        $content = $this->buildMarkup($dataModel, $containerTag, []);

        $body->write($content);

        return $response->withBody($body)->withHeader(
            'Content-Type',
            'text/html'
        );
    }
}

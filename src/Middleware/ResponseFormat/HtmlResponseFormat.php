<?php

namespace Reliv\PipeRat\Middleware\ResponseFormat;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\RcmApiLib\Model\ApiSerializableInterface;

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
     * @return \Psr\Http\Message\MessageInterface
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        if (!$this->isValidAcceptType($request)) {
            return $next($request, $response);
        }

        $containerTag = $this->getOption($request, 'containerTag', 'div');

        $dataModel = $this->getDataModelArray($response, null);

        $body = $response->getBody();
        $content = $body->getContents();

        if (is_array($dataModel)) {
            $content = $this->buildMarkup($dataModel, $containerTag, []);
        }

        $body->write($content);

        return $response->withBody($body)->withHeader(
            'Content-Type',
            'text/html'
        );
    }
}

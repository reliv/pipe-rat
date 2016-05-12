<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\ResponseModel\ZfInputFilterMessageResponseModels;
use Zend\InputFilter\InputFilter;

/**
 * Class ZfInputFilterClass
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfInputFilterClass extends AbstractMiddleware implements Middleware
{
    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $out
     *
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $filterClass = $this->getOption($request, 'class', '');

        /** @var InputFilter $inputFilter */
        $inputFilter = new $filterClass();

        $dataModel = $request->getParsedBody();

        $inputFilter->setData($dataModel);

        if($inputFilter->isValid()) {
            return $out($request, $response);
        }

        $messages = new ZfInputFilterMessageResponseModels(
            $inputFilter,
            $this->getOption($request, 'primaryMessage', 'An Error Occurred'),
            $this->getOption($request, 'messageParams', [])
        );

        return $this->getResponseWithDataBody($response, $messages);
    }
}

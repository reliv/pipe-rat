<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\ResponseModel\ResponseModel;
use Reliv\PipeRat\ResponseModel\ZfInputFilterMessageResponseModels;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class AbstractZfInputFilter
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class AbstractZfInputFilter extends AbstractMiddleware implements Middleware
{
    /**
     * getInputFilter
     *
     * @param Request $request
     *
     * @return InputFilterInterface
     */
    abstract protected function getInputFilter(Request $request);

    /**
     * getResponseModel
     *
     * @param InputFilterInterface $inputFilter
     * @param string               $primaryMessage
     * @param array                $messageParams
     *
     * @return ResponseModel
     */
    protected function getResponseModel(
        InputFilterInterface $inputFilter,
        $primaryMessage = 'An Error Occurred',
        $messageParams = []
    ) {
        return new ZfInputFilterMessageResponseModels(
            $inputFilter,
            $primaryMessage,
            $messageParams
        );
    }

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
        /** @var InputFilterInterface $inputFilter */
        $inputFilter = $this->getInputFilter($request);

        $dataModel = $request->getParsedBody();

        $inputFilter->setData($dataModel);

        if ($inputFilter->isValid()) {
            return $out($request, $response);
        }

        $messages = $this->getResponseModel(
            $inputFilter,
            $this->getOption($request, 'primaryMessage', 'An Error Occurred'),
            $this->getOption($request, 'messageParams', [])
        );

        $response = $this->getResponseWithDataBody($response, $messages);

        $status = $this->getOption($request, 'badRequestStatus', 400);

        $response = $response->withStatus($status);

        return $out($request, $response);
    }
}

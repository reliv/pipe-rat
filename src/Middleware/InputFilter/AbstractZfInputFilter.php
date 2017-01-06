<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\ErrorResponse\Model\BasicErrorResponse;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\ResponseModel\ResponseModel;
use Reliv\PipeRat\ResponseModel\ZfInputFilterMessageResponseModels;
use Reliv\PipeRat\ZfInputFilter\Hydrator\ZfInputFilterErrorHydrator;
use Reliv\PipeRat\ZfInputFilter\Model\InputFilterError;
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
     * @var ZfInputFilterErrorHydrator
     */
    protected $zfInputFilterErrorHydrator;

    /**
     * Constructor.
     *
     * @param ZfInputFilterErrorHydrator $zfInputFilterErrorHydrator
     */
    public function __construct(
        ZfInputFilterErrorHydrator $zfInputFilterErrorHydrator
    ) {
        $this->zfInputFilterErrorHydrator = $zfInputFilterErrorHydrator;
    }

    /**
     * getInputFilter
     *
     * @param Request $request
     *
     * @return InputFilterInterface
     */
    abstract protected function getInputFilter(Request $request);

    /**
     * getErrorResponse
     *
     * @param InputFilterInterface $inputFilter
     * @param array                $options
     *
     * @return \Reliv\PipeRat\ErrorResponse\Model\Error
     */
    protected function getErrorResponse(
        InputFilterInterface $inputFilter,
        $options = []
    ) {

        $error = new InputFilterError();

        return $this->zfInputFilterErrorHydrator->hydrate($error, $inputFilter, $options);
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

        $messages = $this->getErrorResponse(
            $inputFilter,
            $this->getOption($request, 'hydratorOptions', [])
        );

        $response = $this->getResponseWithDataBody($response, $messages);

        $status = $this->getOption($request, 'badRequestStatus', 400);

        $response = $response->withStatus($status);

        return $out($request, $response);
    }
}

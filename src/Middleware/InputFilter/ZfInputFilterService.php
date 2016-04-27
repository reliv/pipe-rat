<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\RcmApiLib\Model\InputFilterApiMessages;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;
use Zend\InputFilter\InputFilter;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ZfInputFilterService
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfInputFilterService extends AbstractMiddleware implements Middleware
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceManager
     */
    public function __construct(
        ServiceLocatorInterface $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
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
        $filterService = $this->getOption($request, 'serviceName', '');

        /** @var InputFilter $inputFilter */
        $inputFilter = $this->serviceManager->get($filterService);

        $dataModel = $this->getRequestData($request, []);

        $inputFilter->setData($dataModel);

        if($inputFilter->isValid()) {
            return $out($request, $response);
        }

        $messages = new InputFilterApiMessages(
            $inputFilter,
            $this->getOption($request, 'primaryMessage', 'An Error Occurred'),
            $this->getOption($request, 'messageParams', [])
        );

        return $this->withDataResponse($response, $messages);
    }
}

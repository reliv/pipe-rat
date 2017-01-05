<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\Middleware;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ZfInputFilterService
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfInputFilterService extends AbstractZfInputFilter implements Middleware
{
    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * @param ContainerInterface $serviceManager
     */
    public function __construct(
        $serviceManager
    ) {
        $this->serviceManager = $serviceManager;
    }

    /**
     * getInputFilter
     *
     * @param Request $request
     *
     * @return InputFilterInterface
     */
    protected function getInputFilter(Request $request)
    {
        $filterService = $this->getOption($request, 'serviceName', '');

        /** @var InputFilter $service */
        $service = $this->serviceManager->get($filterService);

        return clone($service);
    }
}

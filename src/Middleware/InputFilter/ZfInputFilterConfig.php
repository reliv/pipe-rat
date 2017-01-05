<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\Middleware;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ZfInputFilterConfig
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfInputFilterConfig extends AbstractZfInputFilter implements Middleware
{
    /**
     * getInputFilter
     *
     * @param Request $request
     *
     * @return InputFilterInterface
     */
    protected function getInputFilter(Request $request)
    {
        $filterConfig = $this->getOption($request, 'config', []);

        $inputFilter = new InputFilter();

        $factory = $inputFilter->getFactory();

        foreach ($filterConfig as $field => $config) {
            $inputFilter->add(
                $factory->createInput(
                    $config
                )
            );
        }

        return $inputFilter;
    }
}

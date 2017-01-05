<?php

namespace Reliv\PipeRat\Middleware\InputFilter;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\Middleware;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class ZfInputFilterClass
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ZfInputFilterClass extends AbstractZfInputFilter implements Middleware
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
        $filterClass = $this->getOption($request, 'class', '');

        return new $filterClass();
    }
}

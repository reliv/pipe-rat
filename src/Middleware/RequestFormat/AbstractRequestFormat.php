<?php

namespace Reliv\PipeRat\Middleware\RequestFormat;

use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\AbstractMiddleware;

/**
 * Class AbstractRequestFormat
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractRequestFormat extends AbstractMiddleware
{
    /**
     * @var array
     */
    protected $defaultContentTypes = [];

    /**
     * isValidAcceptType
     *
     * @param Request $request
     *
     * @return bool
     */
    public function isValidContentType(Request $request)
    {
        $options = $this->getOptions($request);

        $validContentTypes = $options->get(
            'contentTypes',
            $this->defaultContentTypes
        );

        // allow this for all check
        if (in_array('*/*', $validContentTypes)) {
            return true;
        }

        $contentTypes = $request->getHeader('Content-Type');

        foreach ($contentTypes as $contentType) {
            if (in_array($contentType, $validContentTypes)) {
                return true;
            }
        }

        return false;
    }
}

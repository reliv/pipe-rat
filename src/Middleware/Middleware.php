<?php

namespace Reliv\PipeRat\Middleware;

/**
 * Class Middleware
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   MiddlewareInterface
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface Middleware extends \Zend\Stratigility\MiddlewareInterface
{
    /**
     * Request Attribute Id
     */
    const REQUEST_ATTRIBUTE_RESOURCE_KEY = 'api-lib-resource-key';

    /**
     * Request Attribute Id
     */
    const REQUEST_ATTRIBUTE_RESOURCE_METHOD_KEY = 'api-lib-resource-method-key';
}

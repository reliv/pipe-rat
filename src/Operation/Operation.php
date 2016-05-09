<?php

namespace Reliv\PipeRat\Operation;

use Reliv\PipeRat\Exception\ServiceMissingException;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\Options;

/**
 * Class Operation
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ServiceModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface Operation
{
    /**
     * getName
     *
     * @return string
     */
    public function getName();
    
    /**
     * getMiddleware
     *
     * @return null|callable|object|Middleware compatible
     */
    public function getMiddleware();

    /**
     * getOptions
     *
     * @return Options
     */
    public function getOptions();

    /**
     * getPriority
     *
     * @return int
     */
    public function getPriority();
}

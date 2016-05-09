<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Exception\ServiceMissingException;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\Options;

/**
 * @deprecated
 * Class ServiceModelCollection
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
interface ServiceModelCollection
{
    /**
     * getServices
     *
     * @return array ['{serviceAlias}' => {Middleware}]
     */
    public function getServices();

    /**
     * getService
     *
     * @param string $serviceAlias
     *
     * @return Middleware
     * @throws ServiceMissingException
     */
    public function getService($serviceAlias);

    /**
     * hasService
     *
     * @param string $serviceAlias
     *
     * @return bool
     */
    public function hasService($serviceAlias);

    /**
     * getOptions
     *
     * @param string $serviceAlias
     *
     * @return Options
     */
    public function getOptions($serviceAlias);

    /**
     * getPriority
     *
     * @param string $serviceAlias
     * 
     * @return int
     */
    public function getPriority($serviceAlias);
}

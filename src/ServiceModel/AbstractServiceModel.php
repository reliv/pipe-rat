<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Exception\ServiceMissingException;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\Options;

/**
 * @deprecated
 * Class AbstractServiceModel
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
abstract class AbstractServiceModel
{
    /**
     * @var string
     */
    protected $alias;

    /**
     * @var Middleware compatible
     */
    protected $service;

    /**
     * @var Options
     */
    protected $serviceOptions;

    /**
     * @var int
     */
    protected $priority;

    /**
     * AbstractServiceModel constructor.
     *
     * @param string  $alias
     * @param object  $service
     * @param Options $serviceOptions
     * @param int     $priority
     */
    public function __construct(
        $alias,
        $service,
        Options $serviceOptions,
        $priority = 0
    ) {
        $this->alias = $alias;
        $this->service = $service;
        $this->serviceOptions = $serviceOptions;
        $this->priority = $priority;
    }

    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * getService
     *
     * @return object Middleware compatible
     * @throws ServiceMissingException
     */
    public function getService()
    {
        if (empty($this->service)) {
            throw new ServiceMissingException('Service not set');
        }

        return $this->service;
    }

    /**
     * getPreOptions
     *
     * @return Options
     */
    public function getOptions()
    {
        return $this->serviceOptions;
    }

    /**
     * getPriority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}

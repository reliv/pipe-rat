<?php

namespace Reliv\PipeRat\Operation;

use Reliv\PipeRat\Exception\MiddlewareMissingException;
use Reliv\PipeRat\Middleware\Middleware;
use Reliv\PipeRat\Options\Options;

/**
 * Class AbstractOperation
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractOperation
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Middleware compatible
     */
    protected $middleware;

    /**
     * @var Options
     */
    protected $options;

    /**
     * @var int
     */
    protected $priority;

    /**
     * AbstractServiceModel constructor.
     *
     * @param string                          $name
     * @param null|callable|object|Middleware $middleware
     * @param Options                         $options
     * @param int                             $priority
     */
    public function __construct(
        $name,
        $middleware,
        Options $options,
        $priority = 0
    ) {
        $this->name = (string) $name;
        $this->middleware = $middleware;
        $this->options = $options;
        $this->priority = (int) $priority;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * getMiddleware
     *
     * @return null|callable|object|Middleware compatible
     * @throws MiddlewareMissingException
     */
    public function getMiddleware()
    {
        if (empty($this->middleware)) {
            throw new MiddlewareMissingException('Operation not set');
        }

        return $this->middleware;
    }

    /**
     * getPreOptions
     *
     * @return Options
     */
    public function getOptions()
    {
        return $this->options;
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

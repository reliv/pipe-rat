<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Options\Options;

/**
 * class BaseMethodModel
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class BaseMethodModel implements MethodModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $httpVerb;

    /**
     * @var Options
     */
    protected $options;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var ServiceModelCollection
     */
    protected $preServiceModel;

    /**
     * @var ServiceModelCollection
     */
    protected $postServiceModel;

    /**
     * BaseMethodModel constructor.
     *
     * @param string          $name
     * @param string          $description
     * @param string          $httpVerb
     * @param string          $path
     * @param ServiceModelCollection $preServiceModel
     * @param ServiceModelCollection $postServiceModel
     * @param Options                $options
     */
    public function __construct(
        $name,
        $description,
        $httpVerb,
        $path,
        ServiceModelCollection $preServiceModel,
        ServiceModelCollection $postServiceModel,
        Options $options
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->httpVerb = $httpVerb;
        $this->path = $path;
        $this->preServiceModel = $preServiceModel;
        $this->postServiceModel = $postServiceModel;
        $this->options = $options;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return (string)$this->name;
    }

    /**
     * getDescription
     *
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }

    /**
     * getHttpVerb
     *
     * @return string
     */
    public function getHttpVerb()
    {
        return strtoupper((string)$this->httpVerb);
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
     * getPath
     *
     * @return string
     */
    public function getPath()
    {
        return (string)$this->path;
    }

    /**
     * getPreService
     *
     * @return ServiceModelCollection
     */
    public function getPreServiceModel()
    {
        return $this->preServiceModel;
    }

    /**
     * getPostServiceModel
     *
     * @return ServiceModelCollection
     */
    public function getPostServiceModel()
    {
        return $this->postServiceModel;
    }
}

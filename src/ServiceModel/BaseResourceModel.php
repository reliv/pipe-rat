<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Options\Options;

/**
 * Class BaseResourceModel
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class BaseResourceModel implements ResourceModel
{
    /**
     * @var string
     */
    protected $resourceKey;
    
    /**
     * @var ControllerModel
     */
    protected $controllerModel;

    /**
     * @var
     */
    protected $methodsIndex;

    /**
     * @var array ['{methodName}' => {MethodModel}]
     */
    protected $methodModels = [];

    /**
     * @var array
     */
    protected $methodsAllowed = [];

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
     * @var array
     */
    protected $methodPriorities;

    /**
     * BaseResourceModel constructor.
     *
     * @param ControllerModel        $controllerModel
     * @param array                  $methodsAllowed
     * @param array                  $methodModels
     * @param array                  $methodPriorities
     * @param string                 $path
     * @param ServiceModelCollection $preServiceModel
     * @param ServiceModelCollection $postServiceModel
     * @param Options                $options
     */
    public function __construct(
        ControllerModel $controllerModel,
        array $methodsAllowed,
        array $methodModels,
        array $methodPriorities,
        $path,
        ServiceModelCollection $preServiceModel,
        ServiceModelCollection $postServiceModel,
        Options $options
    ) {
        $this->methodsIndex = new \SplPriorityQueue();
        $this->controllerModel = $controllerModel;
        $this->methodsAllowed = $methodsAllowed;

        $cnt = count($methodModels);
        foreach ($methodModels as $methodName => $methodModel) {
            $priority = $cnt;
            if (array_key_exists($methodName, $methodPriorities)) {
                $priority = $methodPriorities[$methodName];
            }
            $this->addMethod($methodName, $methodModel, $priority);
            $cnt--;
        }
        $this->options = $options;
        $this->path = $path;
        $this->preServiceModel = $preServiceModel;
        $this->postServiceModel = $postServiceModel;
        $this->methodPriorities = $methodPriorities;
    }

    /**
     * addMethod
     *
     * @param string      $methodName
     * @param MethodModel $methodModel
     * @param int         $priority
     *
     * @return void
     */
    protected function addMethod($methodName, MethodModel $methodModel, $priority = 0)
    {
        $this->methodsIndex->insert($methodName, $priority);
        $this->methodModels[$methodName] = $methodModel;
    }

    /**
     * getControllerModel
     *
     * @return ServiceModel
     */
    public function getControllerModel()
    {
        return $this->controllerModel;
    }

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getMethodsAllowed()
    {
        return $this->methodsAllowed;
    }

    /**
     * getMethods
     *
     * @return array MethodModel
     */
    public function getMethodModels()
    {
        $methodModels = [];
        foreach ($this->methodsIndex as $serviceAlias) {
            $methodModels[$serviceAlias] = $this->methodModels[$serviceAlias];
        }

        return $methodModels;
    }

    /**
     * getAvailableMethodModels
     *
     * @return array
     */
    public function getAvailableMethodModels()
    {
        $methodModels = $this->getMethodModels();
        $methodsAllowed = $this->getMethodsAllowed();
        $availableMethodModels = [];
        foreach ($methodModels as $name => $methodModel) {
            if (in_array($name, $methodsAllowed)) {
                $availableMethodModels[$name] = $methodModel;
            }
        }

        return $availableMethodModels;
    }

    /**
     * getMethod
     *
     * @param string $name
     *
     * @return MethodModel|null
     */
    public function getMethodModel($name)
    {
        if ($this->hasMethod($name)) {
            return $this->methodModels[$name];
        }

        return null;
    }

    /**
     * hasMethod
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMethod($name)
    {
        return array_key_exists($name, $this->methodModels);
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
        return $this->path;
    }

    /**
     * getPreServiceModel
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

    /**
     * getPriorities
     *
     * @return array
     */
    public function getPriorities()
    {
        return $this->methodPriorities;
    }
}

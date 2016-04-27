<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Options\Options;

/**
 * Interface Resource
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
interface ResourceModel extends OptionsModel
{
    /**
     * Request Attribute Id
     */
    const REQUEST_ATTRIBUTE_MODEL_RESOURCE = 'api-lib-resource-model-resource';
    
    /**
     * getControllerModel
     *
     * @return ServiceModel
     */
    public function getControllerModel();

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getMethodsAllowed();

    /**
     * getMethods
     *
     * @return array
     */
    public function getMethodModels();

    /**
     * getAvailableMethodModels
     * Return only the methods in the available list
     * Shall be ordered by the methodsModels list
     *
     * @return array
     */
    public function getAvailableMethodModels();

    /**
     * getMethod
     *
     * @param string $name
     *
     * @return MethodModel|null
     */
    public function getMethodModel($name);

    /**
     * hasMethod
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasMethod($name);

    /**
     * getPath
     *
     * @return string
     */
    public function getPath();

    /**
     * getPreServiceModel
     *
     * @return ServiceModelCollection
     */
    public function getPreServiceModel();

    /**
     * getPostServiceModel
     *
     * @return ServiceModelCollection
     */
    public function getPostServiceModel();

    /**
     * getPriorities
     *
     * @return array
     */
    public function getPriorities();
}

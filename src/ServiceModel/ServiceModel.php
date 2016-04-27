<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Exception\ServiceMissingException;
use Reliv\PipeRat\Options\Options;

/**
 * Class ServiceModel
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
interface ServiceModel extends OptionsModel
{
    /**
     * getAlias
     *
     * @return string
     */
    public function getAlias();
    
    /**
     * getService
     *
     * @return object  Middleware compatible
     * @throws ServiceMissingException
     */
    public function getService();
}

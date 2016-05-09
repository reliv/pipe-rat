<?php

namespace Reliv\PipeRat\ServiceModel;

use Reliv\PipeRat\Options\Options;

/**
 * @deprecated
 * Class OptionsModel
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
interface OptionsModel
{
    /**
     * getOptions
     *
     * @return Options
     */
    public function getOptions();
}

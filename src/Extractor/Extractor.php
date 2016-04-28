<?php

namespace Reliv\PipeRat\Extractor;

use Reliv\PipeRat\Options\Options;

/**
 * Class Extractor
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Extractor
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface Extractor
{
    /**
     * extract
     *
     * @param mixed   $object
     * @param Options $options
     *
     * @return mixed
     */
    public function extract($object, Options $options);
}

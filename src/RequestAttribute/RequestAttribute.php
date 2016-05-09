<?php

namespace Reliv\PipeRat\RequestAttribute;

/**
 * Class RequestAttribute
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\RequestAttribute
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface RequestAttribute
{
    /**
     * getName
     *
     * @return mixed
     */
    public static function getName();

    /**
     * getName
     *
     * @return string
     */
    public function getAttributeName();
}

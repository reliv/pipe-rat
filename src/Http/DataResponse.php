<?php

namespace Reliv\PipeRat\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Class DataResponse
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Http
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
interface DataResponse extends ResponseInterface
{
    /**
     * withDataBody
     *
     * @param mixed $data
     *
     * @return \Psr\Http\Message\MessageInterface|ResponseInterface
     */
    public function withDataBody($data);

    /**
     * getDataBody
     *
     * @return mixed
     */
    public function getDataBody();
}

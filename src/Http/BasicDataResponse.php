<?php

namespace Reliv\PipeRat\Http;

use Psr\Http\Message\ResponseInterface;

/**
 * Class BasicDataResponse
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
class BasicDataResponse extends Response implements DataResponse
{
    /**
     * @var null
     */
    protected $dataBody = null;

    /**
     * withDataBody
     *
     * @param mixed $dataBody
     *
     * @return \Psr\Http\Message\MessageInterface|ResponseInterface
     */
    public function withDataBody($dataBody)
    {
        $new = clone $this;
        $new->dataBody = $dataBody;

        return $new;
    }

    /**
     * getDataBody
     *
     * @return mixed
     */
    public function getDataBody()
    {
        return $this->dataBody;
    }
}

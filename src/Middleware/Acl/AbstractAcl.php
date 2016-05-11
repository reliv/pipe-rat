<?php

namespace Reliv\PipeRat\Middleware\Acl;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RcmUser\Service\RcmUserService;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class AbstractAcl
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class AbstractAcl extends AbstractMiddleware
{
    /**
     * getResponseWithAclFailStatus
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return static
     */
    protected function getResponseWithAclFailStatus(Request $request, Response $response)
    {
        return $response->withStatus(
            (int)$this->getOption($request, 'notAllowedStatus', 401),
            $this->getOption($request, 'notAllowedReason', '')
        );
    }
}

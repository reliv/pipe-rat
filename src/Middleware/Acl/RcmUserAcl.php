<?php

namespace Reliv\PipeRat\Middleware\Acl;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use RcmUser\Service\RcmUserService;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class RcmUserAcl
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class RcmUserAcl extends AbstractAcl implements Middleware
{
    /**
     * @var RcmUserService
     */
    protected $rcmUserService;

    /**
     * @param RcmUserService $rcmUserService
     */
    public function __construct(
        RcmUserService $rcmUserService
    ) {
        $this->rcmUserService = $rcmUserService;
    }

    /**
     * __invoke
     *
     * @param Request       $request
     * @param Response      $response
     * @param callable|null $next
     *
     * @return mixed
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        $isAllowed = $this->rcmUserService->isAllowed(
            $this->getOption($request, 'resourceId', null),
            $this->getOption($request, 'privilege', null)
        );

        if ($isAllowed) {
            return $next($request, $response);
        }

        return $this->getResponseWithAclFailStatus($request, $response);
    }
}

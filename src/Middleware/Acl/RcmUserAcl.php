<?php

namespace Reliv\PipeRat\Acl\Middleware;

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
class RcmUserAcl extends AbstractMiddleware implements Middleware
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
     * @param callable|null $out
     *
     * @return mixed
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $out = null
    ) {
        $isAllowed = $this->rcmUserService->isAllowed(
            $this->getOption($request, 'resourceId', null),
            $this->getOption($request, 'privilege', null)
        );

        if ($isAllowed) {
            return $out($request, $response);
        }

        return $response->withStatus(
            (int)$this->getOption($request, 'notAllowedStatus', 401),
            $this->getOption($request, 'notAllowedReason', '')
        );
    }
}

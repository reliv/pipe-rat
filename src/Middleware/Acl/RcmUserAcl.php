<?php

namespace Reliv\PipeRat\Middleware\Acl;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Rcm\Acl\AclActions;
use Rcm\Acl\AssertIsAllowed;
use Rcm\Acl\NotAllowedException;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * @deprecated This will be removed eventully. Use the new ACL system instead.
 */
class RcmUserAcl extends AbstractAcl implements Middleware
{
    protected $requestContext;

    public function __construct(ContainerInterface $requestContext)
    {
        $this->requestContext = $requestContext;
    }

    /**
     * @deprecated This will be removed eventully. Use the new ACL system instead.
     *
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     *
     * @return mixed
     */
    public function __invoke(
        Request $request,
        Response $response,
        callable $next = null
    ) {
        /**
         * @var AssertIsAllowed $assertIsAllowed
         */
        $assertIsAllowed = $this->requestContext->get(AssertIsAllowed::class);
        try {
            //Note that "legacy-global-admin-functionality" is temporary and will be removed eventually.
            $assertIsAllowed->__invoke(AclActions::EXECUTE, ['type' => 'legacy-global-admin-functionality']);
            $isAllowed = true;
        } catch (NotAllowedException $e) {
            $isAllowed = false;
        }

        if ($isAllowed) {
            return $next($request, $response);
        }

        return $this->getResponseWithAclFailStatus($request, $response);
    }
}

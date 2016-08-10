<?php
namespace Reliv\PipeRat\Middleware\Header;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use DateTimeImmutable;
use Reliv\PipeRat\Middleware\AbstractMiddleware;

/**
 * Middleware to send Expires header.
 */
class Expires extends AbstractMiddleware
{
    /**
     * Execute the middleware.
     *
     * Example values for "expires" config. This is the same format apache uses in config.
     * +0 seconds
     * +1 hour
     * +1 day
     * +1 week
     * +1 month
     * +1 year
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $options = $this->getOptions($request);
        $expires = $options->get('time', null);
        $httpMethods = $options->get('httpMethods', ['GET', 'OPTIONS']);

        if (!in_array($request->getMethod(), $httpMethods)) {
            return $next($request, $response);
        }

        if (!$expires) {
            return $next($request, $response);
        }

        $expires = new DateTimeImmutable($expires);

        $cacheControl = $response->getHeaderLine('Cache-Control') ?: '';
        $cacheControl .= ' max-age=' . ($expires->getTimestamp() - time());

        return $next(
            $request,
            $response
                ->withHeader('Cache-Control', trim($cacheControl))
                ->withAddedHeader('Cache-Control', 'public')
                ->withHeader('Expires', $expires->format('D, d M Y H:i:s') . ' GMT')
                ->withHeader('Last-Modified', 'Tue, 09 Aug 2016 14:41:46 GMT')//@TODO RM
                ->withHeader('Pragma', 'public')
        );
    }
}

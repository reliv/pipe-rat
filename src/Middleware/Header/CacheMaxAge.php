<?php

namespace Reliv\PipeRat\Middleware\Header;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Reliv\PipeRat\Middleware\AbstractMiddleware;

/**
 * Middleware to send Expires header.
 */
class CacheMaxAge extends AbstractMiddleware
{
    /**
     * Execute the middleware
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param callable          $next
     *
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next)
    {
        $options = $this->getOptions($request);
        $httpMethods = $options->get('httpMethods', ['GET', 'OPTIONS', 'HEAD']);

        if (!in_array($request->getMethod(), $httpMethods)) {
            return $next($request, $response);
        }

        $pragma = $options->get('pragma', 'cache');
        $maxAge = $options->get('max-age', '3600');
        // $lastModifiedDefault = new \DateTime('@0');
        // $lastModified = $lastModifiedDefault->format('D, d M Y H:i:s') . ' GMT';

        $maxAgeValue = "max-age={$maxAge}";

        return $next(
            $request,
            $response
                ->withHeader('cache-control', $maxAgeValue)
                ->withHeader('pragma', $pragma)
                // ->withHeader('Last-Modified', $lastModified)
        );
    }
}

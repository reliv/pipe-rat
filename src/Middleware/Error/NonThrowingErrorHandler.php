<?php


namespace Reliv\PipeRat\Middleware\Error;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Middleware\ErrorMiddlewareInterface;

/**
 * Class NonThrowingErrorHandler
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class NonThrowingErrorHandler implements ErrorMiddlewareInterface
{
    /**
     * @var bool
     */
    protected $displayErrors = false;

    /**
     * NonThrowingErrorHandler constructor.
     */
    public function __construct()
    {
        $this->displayErrors = in_array(ini_get('display_errors'), ['1', 'On', 'true']);
    }

    /**
     * Process an incoming error, along with associated request and response.
     *
     * Accepts an error, a server-side request, and a response instance, and
     * does something with them; if further processing can be done, it can
     * delegate to `$next`.
     *
     * @see MiddlewareInterface
     * @param mixed $error
     * @param Request $request
     * @param Response $response
     * @param null|callable $next
     * @return null|Response
     */
    public function __invoke($error, Request $request, Response $response, callable $next = null)
    {
        //Show error in browser if display_errors is on in php.ini
        if ($this->displayErrors) {
            $body = $response->getBody();
            $body->write($error);

            return $response->withBody($body);
        }

        $body = $response->getBody();
        $body->write('500 Internal Server Error');

        return $response->withStatus(500)->withBody($body);
    }
}

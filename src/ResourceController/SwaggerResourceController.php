<?php

namespace Reliv\PipeRat\ResourceController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class SwaggerResourceController
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class SwaggerResourceController extends AbstractResourceController
{
    public function get(Request $request, Response $response, callable $out)
    {
        $this->getOption($request, 'swagger', []);
    }
}

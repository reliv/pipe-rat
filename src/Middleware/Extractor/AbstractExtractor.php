<?php

namespace Reliv\PipeRat\Middleware\Extractor;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Http\DataResponse;
use Reliv\PipeRat\Middleware\AbstractMiddleware;

/**
 * Class AbstractExtractor
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
abstract class AbstractExtractor extends AbstractMiddleware
{
    /**
     * @var
     */
    protected $extractor;

    /**
     * getExtractor
     *
     * @return \Reliv\PipeRat\Extractor\PropertyGetterExtractor
     */
    abstract public function getExtractor();
    
    /**
     * __invoke
     *
     * @param Request|DataResponse $request
     * @param Response             $response
     * @param callable|null        $out
     *
     * @return static
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $dataModel = $this->getDataModel($response);

        $options = $this->getOptions($request);

        $extractor = $this->getExtractor();

        $dataArray = $extractor->extract($dataModel, $options);

        $response = $this->withDataResponse($response, $dataArray);

        return $out($request, $response);
    }
}

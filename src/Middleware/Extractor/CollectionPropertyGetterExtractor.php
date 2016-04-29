<?php

namespace Reliv\PipeRat\Middleware\Extractor;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Http\DataResponse;
use Reliv\PipeRat\Middleware\Middleware;

/**
 * Class CollectionPropertyGetterExtractor
 *
 * PHP version 5
 *
 * @category  Reliv
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class CollectionPropertyGetterExtractor extends AbstractExtractor implements Middleware
{
    /**
     * @var
     */
    protected $extractor;

    /**
     * getExtractor
     *
     * @return \Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor
     */
    public function getExtractor()
    {
        if (empty($this->extractor)) {
            $this->extractor = new \Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor();
        }

        return $this->extractor;
    }

    /**
     * __invoke
     *
     * @param Request|DataResponse $request
     * @param Response $response
     * @param callable|null $out
     *
     * @return static
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $dataModel = $this->getDataModel($response);

        if (!is_array($dataModel) && !$dataModel instanceof \Traversable) {
            return $out($request, $response);
        }

        return parent::__invoke($request, $response, $out);
    }
}

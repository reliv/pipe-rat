<?php

namespace Reliv\PipeRat\Middleware\Extractor;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Extractor\Extractor;
use Reliv\PipeRat\Http\DataResponse;
use Reliv\PipeRat\Middleware\AbstractMiddleware;
use Reliv\PipeRat\Options\Options;

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
     * @var Extractor
     */
    protected $extractor;

    /**
     * getOptions
     *
     * @param Request $request
     *
     * @return Options
     */
    public function getOptions(Request $request)
    {
        $options = parent::getOptions($request);

        $this->buildPropertyListOption($request, $options);

        return $options;
    }

    /**
     * getFilterPropertyList
     *
     * @param Request $request
     * @param array $default
     *
     * @return array|mixed
     */
    public function getFilterPropertyList(Request $request, $default = [])
    {
        return $request->getAttribute('propertyFilterParam', $default);
    }

    /**
     * buildPropertyListOption
     *
     * @param Request $request
     * @param Options $options
     *
     * @return void
     */
    public function buildPropertyListOption(Request $request, Options $options)
    {
        $filterPropertyList = $this->getFilterPropertyList($request, null);
        $propertyListMerged = $options->get('propertyListMerged', false);

        // Nothing to be done
        if ($filterPropertyList === null && $propertyListMerged) {
            return;
        }

        $defaultPropertyList = $options->get('propertyList', []);

        if (empty($defaultPropertyList)) {
            $options->set('propertyList', $filterPropertyList);

            return;
        }

        $list = $this->buildPropertyList($defaultPropertyList, $filterPropertyList);

        $options->set('propertyList', $list);
        $options->set('propertyListMerged', true);
    }

    /**
     * buildPropertyList
     *
     * @param       $defaultPropertyList
     * @param       $filterPropertyList
     * @param array $list
     *
     * @return array
     */
    protected function buildPropertyList(
        $defaultPropertyList,
        $filterPropertyList,
        &$list = []
    ) {
        if ($filterPropertyList == null) {
            $filterPropertyList = $defaultPropertyList;
        }

        foreach ($filterPropertyList as $filterProperty => $value) {
            // If it is not set in default, we ignore
            if (!array_key_exists($filterProperty, $defaultPropertyList)) {
                continue;
            }

            // If it is set false in default, we ignore
            if ($defaultPropertyList[$filterProperty] === false) {
                continue;
            }

            // We can turn them off if they are disabled
            if ($defaultPropertyList[$filterProperty] === true) {
                $list[$filterProperty] = (bool)$filterPropertyList[$filterProperty];
                continue;
            }

            // If they are arrays, then we check sub values
            if (is_array($defaultPropertyList[$filterProperty]) && is_array($value)) {
                $this->buildPropertyList(
                    $defaultPropertyList[$filterProperty],
                    $filterPropertyList[$filterProperty],
                    $list
                );
                continue;
            }
        }

        return $list;
    }

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
     * @param Response $response
     * @param callable|null $out
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

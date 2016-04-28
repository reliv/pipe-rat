<?php

namespace Reliv\PipeRat\Middleware\Extractor;

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
        if(empty($this->extractor)) {
            $this->extractor = new \Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor();
        }

        return $this->extractor;
    }
}

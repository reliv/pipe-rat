<?php

namespace Reliv\PipeRat\Hydrator;

use Reliv\PipeRat\Options\Options;

/**
 * Class Hydrator
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
interface Hydrator
{
    /**
     * hydrate
     *
     * @param array           $data
     * @param \stdClass|array $dataModel
     * @param Options         $options
     *
     * @return mixed
     */
    public function hydrate(array $data, $dataModel, Options $options);
}

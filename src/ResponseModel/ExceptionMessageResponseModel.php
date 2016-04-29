<?php

namespace Reliv\PipeRat\ResponseModel;

/**
 * Class ExceptionMessageResponseModel
 *
 * PHP version 5
 *
 * @category  Reliv
 * @package   Reliv\PipeRat\ResponseModel
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2015 Reliv International
 * @license   License.txt
 * @version   Release: <package_version>
 * @link      https://github.com/reliv
 */
class ExceptionMessageResponseModel extends MessageResponseModel
{
    /**
     * @var string type for fields
     */
    protected $typeName = 'exception';

    /**
     * @param \Exception $exception
     * @param array      $params
     * @param bool|true  $primary
     */
    public function __construct(
        \Exception $exception,
        $params = [],
        $primary = true
    ) {
        $this->build($exception, $params);
        $this->setPrimary($primary);
    }

    /**
     * build
     *
     * @return void
     */
    public function build(\Exception $exception, $params = [])
    {
        $exceptionParams = [];

        if (method_exists($exception, 'getParms')) {
            // @todo this should be in its own class
            $exceptionParams = $exception->getParms();
        }

        if (is_array($exceptionParams)) {
            $params = array_merge($exceptionParams, $params);
        }

        $code = $exception->getCode();

        if (empty($code)) {
            $code = null;
        }

        $this->setType($this->typeName);
        $this->setValue($exception->getMessage());
        $this->setSource($this->getSourceString($exception));
        $this->setCode($code);
        $this->setParams($params);
    }

    /**
     * getSourceString
     *
     * @param $exception
     *
     * @return string
     */
    public function getSourceString(\Exception $exception)
    {
        $className = get_class($exception);
        if ($pos = strrpos($className, '\\')) {
            $className = lcfirst(substr($className, $pos + 1));
        }

        return $className;
    }
}

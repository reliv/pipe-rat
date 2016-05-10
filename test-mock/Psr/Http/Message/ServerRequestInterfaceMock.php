<?php

namespace Reliv\PipeRat\TestMock\Psr\Http\Message;

use PhpUnitMock\Mock;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ServerRequestInterfaceMock
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ServerRequestInterfaceMock extends Mock
{
    /**
     * NameSpace and Name of the class to mock
     *
     * @var null
     */
    protected $className  = 'Psr\Http\Message\ServerRequestInterface';
    
    /**
     * Build the default mock configuration
     * - Over-ride this in your mock class
     *
     * @return array
     */
    public function buildDefaultConfig()
    {
        return [
            'getServerParams' => [],
            'getCookieParams' => [],
            'withCookieParams' => $this->buildMock(),
            'getQueryParams' => [],
            'withQueryParams' => $this->buildMock(),
            'getUploadedFiles' => [/*UploadedFileInterface*/],
            'withUploadedFiles' => $this->buildMock(),
            'getParsedBody' => [],
            'withParsedBody' =>  $this->buildMock(),
            'getAttributes' => [],
            'getAttribute' => [
                // MAP
            ],
            'withAttribute' => $this->buildMock(),
            'withoutAttribute' => $this->buildMock(),
        ];
    }

    /**
     * Build PHPUnit Mock in this method using $this->config for return values
     * Over-ride this for custom mock building
     *
     * @return \Psr\Http\Message\ServerRequestInterface
     * @throws \Exception
     */
    public function buildMock()
    {
        if (empty($this->className)) {
            throw new \Exception('Class name is required for default buildMock');
        }
        $config = $this->config;
        $mock = $this->testCase->getMockBuilder($this->className)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($config as $key => $returnValue) {
            $mock->method($key)
                ->will($this->testCase->returnValue($returnValue));
        }

        return $mock;
    }
}

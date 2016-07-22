Pipe Rat
========

Create REST APIs with just a few lines of config. This PSR7 compliant PHP library that uses Zend\Stragility Middleware at its core.

## @todo Docs ##

- There is a name collision happening when pre and|or post service options have the same name
    I.E.: responseHeaders in this example, looses the postServiceOptions values in the 'findById'
    ```php
    'xxx' => [
        'controllerServiceName' => 'Reliv\PipeRat\Middleware\ResourceController\DoctrineResourceController',
        'controllerServiceOptions' => [
            'entity' => null,
        ],
        'methods' => [
            'findById' => [
                'postServiceNames' => [
                    'extractor' => 'Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor',
                    'responseHeaders' => 'Reliv\PipeRat\Middleware\Header\AddResponseHeaders',
                ],
                'postServiceOptions' => [
                     'responseHeaders' => [
                          'headers' => [
                              'My' => 'header'
                          ]
                      ]
                ],
            ],
        ],
        'preServiceOptions' => [
        ],
        'preServicePriority' => [
            // 'JsonRequestFormat' => 1000,
        ],
        'postServiceNames' => [
            'responseHeaders' => 'Reliv\PipeRat\Middleware\Header\AddResponseHeaders',
            'JsonResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
            'XmlResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat',
            'DefaultResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
        ],
        'postServiceOptions' => [
            'DefaultResponseFormat' => [
                'accepts' => [
                    '*/*'
                ],
            ],
        ],
    ]
     ```


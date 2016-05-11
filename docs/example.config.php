<?php
/**
 * example.config.php
 */
[
    'resources' => [
        'example-path' => [
            /**
             * === Resource Controller ===
             */
            // '{serviceName}'
            'controllerServiceName' => 'Reliv\PipeRat\ResourceController\DoctrineResourceController',
            // '{optionKey}' => '{optionValue}'
            'controllerServiceOptions' => [
                'entity' => null,
            ],
            /**
             * === Extend an existing config ===
             */
            // OPTIONAL
            // '{defaultResourceConfigKey}'
            'extendsConfig' => 'doctrineApi',

            /**
             * === DEFAULT: Resource Controller Method Definitions ===
             *
             * NOTE: Default priority is LAST wins
             */
            'methods' => [
                'exampleFindOne' => [
                    'controllerMethod' => 'findOne',
                    'description' => 'Example find resources',
                    'httpVerb' => 'GET',
                    'path' => '/exampleFindOne',
                    'preServiceNames' => [
                        'WhereFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where',
                        'PropertyFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields',
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => 'Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor',
                    ],
                    'postServiceOptions' => [
                        'extractor' => [
                            'propertyList' => [
                                'exampleProperty' => true,
                                'exampleCollectionProperty' => ['exampleSubProperty' => true],
                                'exmpleBlacklistProperty' => false,
                            ],
                            // Security is best when 'deepPropertyLimit' is 1
                            'propertyDepthLimit' => 1,
                        ],
                    ],
                    'postServicePriority' => [],
                ],
                'exampleFind' => [
                    'controllerMethod' => 'find',
                    'description' => 'Find resources',
                    'httpVerb' => 'GET',
                    'path' => '/exampleFind',
                    'preServiceNames' => [
                        'WhereFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where',
                        'PropertyFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields',
                        'OrderByFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Order',
                        'SkipFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Skip',
                        'LimitFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Limit',
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => 'Reliv\PipeRat\Middleware\Extractor\CollectionPropertyGetterExtractor',
                    ],
                    'postServiceOptions' => [
                        'extractor' => [
                            'propertyList' => [
                                'exampleProperty' => true,
                                'exampleCollectionProperty' => ['exampleSubProperty' => true],
                                'exmpleBlacklistProperty' => false,
                            ],
                            // Security is best when 'deepPropertyLimit' is 1
                            'propertyDepthLimit' => 1,
                        ],
                    ],
                    'postServicePriority' => [],
                ],
                'exampleDownload' => [
                    'controllerMethod' => 'findById',
                    'description' => 'Download resource by ID',
                    'httpVerb' => 'GET',
                    'path' => '/download/{id}',
                    'preServiceNames' => [
                        'PropertyFilterParam' => 'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields',
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => 'Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor',
                        'fileDataResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\FileDataResponseFormat',
                    ],
                    'postServiceOptions' => [
                        'fileDataResponseFormat' => [
                            'accepts' => ['*/*'],
                            'fileBase64Property' => 'file',
                            // OPTIONAL
                            'fileContentTypeProperty' => 'fileType',
                            // OPTIONAL
                            'fileNameProperty' => 'fileName',
                            // OPTIONAL
                            'fileName' => 'id-image',
                            // OPTIONAL
                            'downloadQueryParam' => 'download',
                            // OPTIONAL
                            'forceContentType' => 'image/jpg',
                        ],
                    ],
                    'postServicePriority' => [],
                ],
            ],
            /* Methods White-list */
            'methodsAllowed' => [
                //Reads
                'count',
                'exists',
                'findById',
                'findOne',
                'find',
                //Writes
                'upsert',
                'create',
                'deleteById',
                'updateProperties',
                'example',
            ],
            'methodPriority' => [
                // OPTIONAL
                // 'count' => 1000,
            ],
            /* Path */
            'path' => 'example-path',
            /* Pre Controller Middleware */
            'preServiceNames' => [
                'RcmUserAcl' => 'Reliv\PipeRat\Middleware\Acl\RcmUserAcl',
                'ZfInputFilterClass' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterClass',
                'ZfInputFilterConfig' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterConfig',
                'ZfInputFilterService' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterService',
                'SomeCustomHeaders' => 'Reliv\PipeRat\Middleware\Header\AddResponseHeaders',
            ],
            'preServiceOptions' => [
                'RcmUserAcl' => [
                    'resourceId' => '{resourceId}',
                    'privilege' => null,
                    'notAllowedStatus' => 401, // optional
                    'notAllowedReason' => 'Access Denied' // optional
                ],
                'ZfInputFilterClass' => [
                    'class' => '',
                ],
                'ZfInputFilterService' => [
                    'serviceName' => '',
                ],
                'ZfInputFilterConfig' => [
                    'config' => [],
                ],
                'SomeCustomHeaders' => [
                    'headers' => [
                        '{headerName}' => [
                            'headerValue1',
                            'headerValue2',
                        ],
                    ],
                ],
            ],
            /**
             * '{serviceAlias}' => {priority},
             */
            'preServicePriority' => [
                // OPTIONAL
            ],
            'postServiceNames' => [
                'JsonResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
                'XmlResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat',
                'DefaultResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
            ],
            /**
             * '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ],
             */
            'postServiceOptions' => [
                'JsonResponseFormat' => [
                    'accepts' => [
                        'application/json'
                    ],
                ],
                'XmlResponseFormat' => [
                    'accepts' => [
                        'application/xml'
                    ],
                ],
                'DefaultResponseFormat' => [
                    'accepts' => [
                        '*/*'
                    ],
                ],
            ],
            'postServicePriority' => [
                // OPTIONAL
                'JsonRequestFormat' => 1000,
                // OPTIONAL
                'XmlResponseFormat' => 900,
                // OPTIONAL
                'DefaultResponseFormat' => 800
            ],
        ],
    ]
];

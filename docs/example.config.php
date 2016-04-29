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
                // Security is best when 'allowDeepWheres' is false
                'allowDeepWheres' => false,
            ],
            /**
             * === Extend an existing config ===
             */
            // '{serviceName}'
            'extendsConfig' => 'default:doctrineApi',

            'methods' => [],
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
                
            ],
            'methodPriority' => [
                //Reads
                'count' => 1000,
                'exists' => 900,
                'findById' => 800,
                'findOne'=> 700,
                'find' => 600,
                //Writes
                'upsert' => 500,
                'create' => 400,
                'deleteById' => 300,
                'updateProperties' => 200,
            ],

            /* Resource Options */
            'options' => [],
            /* Path */
            'path' => 'example-path',
            /* Pre Controller Middleware */
            'preServiceNames' => [
                'RcmUserAcl' => 'Reliv\PipeRat\Middleware\Acl\RcmUserAcl',
                'ZfInputFilterClass' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterClass',
                'ZfInputFilterConfig' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterConfig',
                'ZfInputFilterService' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterService',
            ],
            'preServiceOptions' => [
                'RcmUserAcl' => [
                    'resourceId' => '{resourceId}',
                    'privilege' => null,
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
            ],
            /**
             * '{serviceAlias}' => {priority},
             */
            'preServicePriority' => [
                'JsonRequestFormat' => 1000,
            ],
            'postServiceNames' => [
                'PropertyExtractor' => 'Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor',
                'CollectionPropertyExtractor' => 'Reliv\PipeRat\Middleware\Extractor\CollectionPropertyExtractor',
                'JsonResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
                'XmlResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat',
                'DefaultResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
            ],
            /**
             * '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ],
             */
            'postServiceOptions' => [
                'PropertyExtractor' => [
                    'propertyList' => [
                        // 'propertyName' => {bool|array}
                    ],
                    'propertyDefaultList' => [
                        // 'propertyName'
                    ],
                    // Security is best when 'deepPropertyLimit' is 0
                    'propertyDepthLimit' => 0,
                ],
                'CollectionPropertyExtractor' => [
                    'propertyList' => [
                        // 'propertyName' => {bool|array}
                    ],
                    'propertyDefaultList' => [
                        // 'propertyName'
                    ],
                    // Security is best when 'deepPropertyLimit' is 0
                    'propertyDepthLimit' => 0,
                ],
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
        ],
    ]
];

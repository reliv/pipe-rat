<?php
/**
 * config.php
 *
 * PHP version 5
 *
 * @category  Reliv
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt New BSD License
 * @version   GIT: <git_id>
 * @link      https://github.com/reliv
 */
return [
    'defaultResourceConfig' => [
        /**
         * === Default Empty ==
         */
        'default:empty' => [

            /**
             * === DEFAULT: Resource Controller ===
             */
            // '{serviceName}'
            'controllerServiceName' => null,
            // '{optionKey}' => '{optionValue}'
            'controllerServiceOptions' => [],

            /**
             * === DEFAULT: Resource Controller Method Definitions ===
             * Methods:
             * '{name}' => [
             *   'description' => 'Create new resource',
             *   'httpVerb' => 'POST',
             *   'name' => 'create',
             *   'path' => '{path}',
             *   // '{serviceAlias}' => '{serviceName}'
             *   'preServiceNames' => [],
             *   // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
             *   'preServiceOptions' => [],
             *   // '{serviceAlias}' => {priority}
             *   'preServicePriority' => [],
             *   // '{serviceAlias}' => '{serviceName}'
             *   'postServiceNames' => [],
             *   // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
             *   'postServiceOptions' => [],
             *   // '{serviceAlias}' => {priority}
             *   'postServicePriority' => [],
             * ]
             *
             */
            'methods' => [],
            // '{method}' => {priority}
            'methodPriority' => [],

            /**
             * === DEFAULT: Resource Pre-Services ===
             */
            // '{serviceAlias}' => '{serviceName}'
            'preServiceNames' => [],
            // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
            'preServiceOptions' => [],
            // '{serviceAlias}' => {priority}
            'preServicePriority' => [],

            /**
             * === DEFAULT: Resource Post-Services ===
             */
            //'{serviceAlias}' => '{serviceName}'
            'postServiceNames' => [],
            // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
            'postServiceOptions' => [],
            // '{serviceAlias}' => {priority}
            'postServicePriority' => [],
        ],
        /**
         * === Default Doctrine API ==
         */
        'doctrine-api' => [
            'controllerServiceName' => Reliv\PipeRat\Middleware\ResourceController\DoctrineResourceController::class,
            'controllerServiceOptions' => [
                'entity' => null,
            ],
            'methods' => [
                'findById' => [
                    'controllerMethod' => 'findById',
                    'description' => 'Find resource by ID',
                    'httpVerb' => 'GET',
                    'path' => '/{id}',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'create' => [
                    'controllerMethod' => 'create',
                    'description' => 'Create new resource',
                    'httpVerb' => 'POST',
                    'path' => '',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'upsert' => [
                    'controllerMethod' => 'upsert',
                    'description' => 'Update or create a resource',
                    'httpVerb' => 'PUT',
                    'path' => '',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'exists' => [
                    'controllerMethod' => 'exists',
                    'description' => 'Check if a resource exists',
                    'httpVerb' => 'GET',
                    'path' => '/{id}/exists',
                    'preServiceNames' => [],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'count' => [
                    'controllerMethod' => 'count',
                    'description' => 'Return number of resources',
                    'httpVerb' => 'GET',
                    'path' => '/count',
                    'preServiceNames' => [
                        'WhereFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class,
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'findOne' => [
                    'controllerMethod' => 'findOne',
                    'description' => 'Find resources',
                    'httpVerb' => 'GET',
                    'path' => '/findOne',
                    'preServiceNames' => [
                        'WhereFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class,
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'find' => [
                    'controllerMethod' => 'find',
                    'description' => 'Find resources',
                    'httpVerb' => 'GET',
                    'path' => '',
                    'preServiceNames' => [
                        'WhereFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class,
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                        'OrderByFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Order::class,
                        'SkipFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Skip::class,
                        'LimitFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Limit::class,
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\CollectionPropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'deleteById' => [
                    'controllerMethod' => 'deleteById',
                    'description' => 'Delete resource by ID',
                    'httpVerb' => 'DELETE',
                    'path' => '/{id}',
                    'preServiceNames' => [],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'updateProperties' => [
                    'controllerMethod' => 'updateProperties',
                    'description' => 'Update resource properties by ID',
                    'httpVerb' => 'PUT',
                    'path' => '/{id}',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
            ],
            'methodPriority' => [
            ],
            'options' => [],
            'preServiceNames' => [
//                'JsonRequestFormat' => Reliv\PipeRat\Middleware\RequestFormat\JsonRequestFormat::class,
            ],
            'preServiceOptions' => [
            ],
            'preServicePriority' => [
//                'JsonRequestFormat' => 1000,
            ],
            'postServiceNames' => [
                'finalResponseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                'JsonResponseFormat' => Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat::class,
                'XmlResponseFormat' => Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat::class,
                'DefaultResponseFormat' => Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat::class,
            ],
            'postServiceOptions' => [
                'DefaultResponseFormat' => [
                    'accepts' => [
                        '*/*'
                    ],
                ],
            ],
            'postServicePriority' => [
                'JsonRequestFormat' => 1000,
                'XmlResponseFormat' => 900,
                'DefaultResponseFormat' => 800
            ],
        ],

        /**
         * === Default Repository API ==
         */
        'repository-api' => [
            'controllerServiceName' => Reliv\PipeRat\Middleware\ResourceController\RepositoryResourceController::class,
            'controllerServiceOptions' => [
                'entityIdFieldName' => 'id',
                'entity' => null,
                'repository' => null,
            ],
            'methods' => [
                'findById' => [
                    'controllerMethod' => 'findById',
                    'description' => 'Find resource by ID',
                    'httpVerb' => 'GET',
                    'path' => '/{id}',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'create' => [
                    'controllerMethod' => 'create',
                    'description' => 'Create new resource',
                    'httpVerb' => 'POST',
                    'path' => '',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'upsert' => [
                    'controllerMethod' => 'upsert',
                    'description' => 'Update or create a resource',
                    'httpVerb' => 'PUT',
                    'path' => '',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'exists' => [
                    'controllerMethod' => 'exists',
                    'description' => 'Check if a resource exists',
                    'httpVerb' => 'GET',
                    'path' => '/{id}/exists',
                    'preServiceNames' => [],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'count' => [
                    'controllerMethod' => 'count',
                    'description' => 'Return number of resources',
                    'httpVerb' => 'GET',
                    'path' => '/count',
                    'preServiceNames' => [
                        'WhereFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class,
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'findOne' => [
                    'controllerMethod' => 'findOne',
                    'description' => 'Find resources',
                    'httpVerb' => 'GET',
                    'path' => '/findOne',
                    'preServiceNames' => [
                        'WhereFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class,
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'find' => [
                    'controllerMethod' => 'find',
                    'description' => 'Find resources',
                    'httpVerb' => 'GET',
                    'path' => '',
                    'preServiceNames' => [
                        'WhereFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class,
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                        'OrderByFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Order::class,
                        'SkipFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Skip::class,
                        'LimitFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Limit::class,
                    ],
                    'preServiceOptions' => [
                        'WhereFilterParam' => [
                            // Security is best when 'allowDeepWheres' is false
                            'allowDeepWheres' => false,
                        ]
                    ],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\CollectionPropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'deleteById' => [
                    'controllerMethod' => 'deleteById',
                    'description' => 'Delete resource by ID',
                    'httpVerb' => 'DELETE',
                    'path' => '/{id}',
                    'preServiceNames' => [],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
                'updateProperties' => [
                    'controllerMethod' => 'updateProperties',
                    'description' => 'Update resource properties by ID',
                    'httpVerb' => 'PUT',
                    'path' => '/{id}',
                    'preServiceNames' => [
                        'PropertyFilterParam' => Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class,
                    ],
                    'preServiceOptions' => [],
                    'preServicePriority' => [],
                    'postServiceNames' => [
                        'extractor' => Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class,
                        'responseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                    ],
                    'postServiceOptions' => [],
                    'postServicePriority' => [],
                ],
            ],
            'methodPriority' => [
            ],
            'options' => [],
            'preServiceNames' => [
//                'JsonRequestFormat' => Reliv\PipeRat\Middleware\RequestFormat\JsonRequestFormat::class,
            ],
            'preServiceOptions' => [
            ],
            'preServicePriority' => [
//                'JsonRequestFormat' => 1000,
            ],
            'postServiceNames' => [
                'finalResponseHeaders' => Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class,
                'JsonResponseFormat' => Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat::class,
                'XmlResponseFormat' => Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat::class,
                'DefaultResponseFormat' => Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat::class,
            ],
            'postServiceOptions' => [
                'DefaultResponseFormat' => [
                    'accepts' => [
                        '*/*'
                    ],
                ],
            ],
            'postServicePriority' => [
                'JsonRequestFormat' => 1000,
                'XmlResponseFormat' => 900,
                'DefaultResponseFormat' => 800
            ],
        ],
    ],
    /**
     * === DEFAULT: Resources Config ===
     * These should be defined by the application
     */
    'resources' => [
    ],

    /**
     * === Router ===
     */
    // '{serviceAlias}' => '{serviceName}'
    'routeServiceNames' => [
        'baseRouter' => 'Reliv\PipeRat\Middleware\Router',
    ],
    // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
    'routeServiceOptions' => [],
    // '{serviceAlias}' => {priority}
    'routeServicePriority' => [],

    /**
     * === Error Handlers ===
     */
    'errorServiceNames' => [
        //'errorHandler' => Reliv\PipeRat\Middleware\Error\TriggerErrorHandler::class,
    ],
    // '{serviceAlias}' => {priority}
    'errorServicePriority' => [],
];

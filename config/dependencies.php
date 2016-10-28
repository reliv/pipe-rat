<?php
/**
 * dependencies.php
 */
return [
    'config_factories' => [
        /* Extractors */
        'Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor' => [],
        'Reliv\PipeRat\Extractor\PropertyGetterExtractor'=> [],

        /* Resource Controllers */
        'Reliv\PipeRat\Middleware\ResourceController\DoctrineResourceController' => [
            'arguments' => [
                'Doctrine\ORM\EntityManager',
                'Reliv\PipeRat\Hydrator\PropertySetterHydrator'
            ],
        ],

        'Reliv\PipeRat\Middleware\ResourceController\RepositoryResourceController' => [
            'arguments' => [
                'ServiceManager',
                'Reliv\PipeRat\Hydrator\PropertySetterHydrator'
            ],
        ],

        /* Hydrators */
        'Reliv\PipeRat\Hydrator\PropertySetterHydrator' => [],

        /* Resource Middleware */
        // ACL
        'Reliv\PipeRat\Middleware\Acl\RcmUserAcl' => [
            'arguments' => [
                'RcmUser\Service\RcmUserService',
            ],
        ],
        // Error Middleware
        'Reliv\PipeRat\Middleware\Error\TriggerErrorHandler' => [],
        'Reliv\PipeRat\Middleware\Error\NonThrowingErrorHandler' => [],

        // Extractor
        'Reliv\PipeRat\Middleware\Extractor\CollectionPropertyGetterExtractor' => [],
        'Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor' => [],

        // Header
        'Reliv\PipeRat\Middleware\Header\AddResponseHeaders' => [],
        'Reliv\PipeRat\Middleware\Header\Expires' => [],

        // InputFilter
        'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterClass' => [],
        'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterConfig' => [],
        'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterService' => [
            'arguments' => [
                'ServiceManager',
            ],
        ],

        // Request Formatter
        'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields'=>[],
        'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Limit'=>[],
        'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Order'=>[],
        'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Skip'=>[],
        'Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where'=>[],
        'Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Fields' => [],
        'Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Limit' => [],
        'Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Order' => [],
        'Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Skip' => [],
        'Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Where' => [],
        'Reliv\PipeRat\Middleware\RequestFormat\JsonParamsRequestFormat' => [],

        // Response Formatter
        'Reliv\PipeRat\Middleware\ResponseFormat\FileDataResponseFormat' => [
            'arguments' => [
                'Reliv\PipeRat\Extractor\PropertyGetterExtractor',
            ],
        ],
        'Reliv\PipeRat\Middleware\ResponseFormat\FileResponseFormat' => [],
        'Reliv\PipeRat\Middleware\ResponseFormat\HtmlListResponseFormat' => [
            'arguments' => [
                'Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor',
            ],
        ],
        'Reliv\PipeRat\Middleware\ResponseFormat\HtmlResponseFormat' => [
            'arguments' => [
                'Reliv\PipeRat\Extractor\PropertyGetterExtractor',
            ],
        ],
        'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat' => [],
        'Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat' => [],

        // Main
        'Reliv\PipeRat\Middleware\BasicConfigMiddleware' => [
            'class' => 'Reliv\PipeRat\Middleware\OperationMiddleware',
            'arguments' => [
                'Reliv\PipeRat\Provider\BasicConfigRouteMiddlewareProvider',
                'Reliv\PipeRat\Provider\BasicConfigErrorMiddlewareProvider',
                'Reliv\PipeRat\Provider\BasicConfigMiddlewareProvider',
            ],
        ],
        'Reliv\PipeRat\Middleware\Router' => [
            'class' => 'Reliv\PipeRat\Middleware\Router\CurlyBraceVarRouter',
        ],
        /* Middleware Providers */
        'Reliv\PipeRat\Provider\BasicConfigErrorMiddlewareProvider' => [
            'arguments' => [
                'Config',
                'ServiceManager',
            ],
        ],
        'Reliv\PipeRat\Provider\BasicConfigMiddlewareProvider' => [
            'arguments' => [
                'Config',
                'ServiceManager',
            ],
        ],
        'Reliv\PipeRat\Provider\BasicConfigRouteMiddlewareProvider' => [
            'arguments' => [
                'Config',
                'ServiceManager',
            ],
        ],
    ],
];

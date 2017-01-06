<?php
/**
 * dependencies.php
 */
return [
    'config_factories' => [
        /* Extractors */
        Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor::class => [],
        Reliv\PipeRat\Extractor\PropertyGetterExtractor::class => [],


        /* Resource Controllers */
        Reliv\PipeRat\Middleware\ResourceController\DoctrineResourceController::class => [
            'arguments' => [
                'Doctrine\ORM\EntityManager',
                Reliv\PipeRat\Hydrator\PropertySetterHydrator::class
            ],
        ],

        Reliv\PipeRat\Middleware\ResourceController\RepositoryResourceController::class => [
            'arguments' => [
                'ServiceManager',
                Reliv\PipeRat\Hydrator\PropertySetterHydrator::class
            ],
        ],

        /* Hydrators */
        Reliv\PipeRat\Hydrator\PropertySetterHydrator::class => [],

        /* Resource Middleware */
        // ACL
        Reliv\PipeRat\Middleware\Acl\RcmUserAcl::class => [
            'arguments' => [
                RcmUser\Service\RcmUserService::class,
            ],
        ],
        // Error Middleware
        Reliv\PipeRat\Middleware\Error\TriggerErrorHandler::class => [],
        Reliv\PipeRat\Middleware\Error\NonThrowingErrorHandler::class => [],

        // Extractor
        Reliv\PipeRat\Middleware\Extractor\CollectionPropertyGetterExtractor::class => [],
        Reliv\PipeRat\Middleware\Extractor\PropertyGetterExtractor::class => [],

        // Header
        Reliv\PipeRat\Middleware\Header\AddResponseHeaders::class => [],
        Reliv\PipeRat\Middleware\Header\CacheMaxAge::class => [],
        Reliv\PipeRat\Middleware\Header\Expires::class => [],

        // InputFilter
        Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterClass::class => [
            'arguments' => [
                \Reliv\PipeRat\ZfInputFilter\Hydrator\ZfInputFilterErrorHydrator::class,
            ],
        ],
        Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterConfig::class => [
            'arguments' => [
                \Reliv\PipeRat\ZfInputFilter\Hydrator\ZfInputFilterErrorHydrator::class,
            ],
        ],
        Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterService::class => [
            'arguments' => [
                \Reliv\PipeRat\ZfInputFilter\Hydrator\ZfInputFilterErrorHydrator::class,
                'ServiceManager',
            ],
        ],
        Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterServiceConfig::class => [
            'arguments' => [
                \Reliv\PipeRat\ZfInputFilter\Hydrator\ZfInputFilterErrorHydrator::class,
                \ZfInputFilterService\InputFilter\ServiceAwareFactory::class,
            ],
        ],

        // Request Formatter
        Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Fields::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Limit::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Order::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Skip::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\UrlEncodedCombinedFilter\Where::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Fields::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Limit::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Order::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Skip::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonParamsFilter\Where::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonParamsRequestFormat::class => [],
        Reliv\PipeRat\Middleware\RequestFormat\JsonRequestFormat::class => [],


        // Response Formatter
        Reliv\PipeRat\Middleware\ResponseFormat\FileDataResponseFormat::class => [
            'arguments' => [
                Reliv\PipeRat\Extractor\PropertyGetterExtractor::class,
            ],
        ],
        Reliv\PipeRat\Middleware\ResponseFormat\FileResponseFormat::class => [],
        //Reliv\PipeRat\Middleware\ResponseFormat\HtmlListResponseFormat::class => [
        //    'arguments' => [
        //        Reliv\PipeRat\Extractor\CollectionPropertyGetterExtractor::class,
        //    ],
        //],
        Reliv\PipeRat\Middleware\ResponseFormat\HtmlResponseFormat::class => [
            'arguments' => [
                Reliv\PipeRat\Extractor\PropertyGetterExtractor::class,
            ],
        ],
        Reliv\PipeRat\Middleware\ResponseFormat\JsonErrorResponseFormat::class => [],
        Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat::class => [],
        Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat::class => [],

        // Main
        'Reliv\PipeRat\Middleware\BasicConfigMiddleware' => [
            'class' => Reliv\PipeRat\Middleware\OperationMiddleware::class,
            'arguments' => [
                Reliv\PipeRat\Provider\BasicConfigRouteMiddlewareProvider::class,
                Reliv\PipeRat\Provider\BasicConfigErrorMiddlewareProvider::class,
                Reliv\PipeRat\Provider\BasicConfigMiddlewareProvider::class,
            ],
        ],
        'Reliv\PipeRat\Middleware\Router' => [
            'class' => Reliv\PipeRat\Middleware\Router\CurlyBraceVarRouter::class,
        ],
        /* Middleware Providers */
        Reliv\PipeRat\Provider\BasicConfigErrorMiddlewareProvider::class => [
            'arguments' => [
                'Config',
                'ServiceManager',
            ],
        ],
        Reliv\PipeRat\Provider\BasicConfigMiddlewareProvider::class => [
            'arguments' => [
                'Config',
                'ServiceManager',
            ],
        ],
        Reliv\PipeRat\Provider\BasicConfigRouteMiddlewareProvider::class => [
            'arguments' => [
                'Config',
                'ServiceManager',
            ],
        ],
        /* ZfInputFilter */
        Reliv\PipeRat\ZfInputFilter\Hydrator\ZfInputFilterErrorHydrator::class => [
            'arguments' => [
                Reliv\PipeRat\ZfInputFilter\Service\FieldErrorsFactory::class
            ],
        ],

        Reliv\PipeRat\ZfInputFilter\Service\FieldErrorsFactory::class => [],
    ],
];

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
    'default' => [
        /* DEFAULT: Resource Controller */
        'controllerServiceName' => 'Reliv\PipeRat\ResourceController\DoctrineResourceController',
        'controllerOptions' => [
            'entity' => null,
            'propertyList' => [
                // 'propertyName' => {bool|array}
            ],
            'propertyDefaultList' => [
                // 'propertyName'
            ],
            // Security is best when 'deepPropertyLimit' is 0
            'propertyDepthLimit' => 0,
            // Security is best when 'allowDeepWheres' is false
            'allowDeepWheres' => false,
        ],
        /* DEFAULT: Resource Controller Method Definitions */
        'methods' => [
            /* Default Methods */
            'create' => [
                'description' => 'Create new resource',
                'httpVerb' => 'POST',
                'name' => 'create',
                'options' => [],
                'path' => '',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'upsert' => [
                'description' => 'Update or create a resource',
                'httpVerb' => 'PUT',
                'name' => 'upsert',
                'options' => [],
                'path' => '',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'exists' => [
                'description' => 'Check if a resource exists',
                'httpVerb' => 'GET',
                'name' => 'exists',
                'options' => [],
                'path' => '{id}/exists',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'count' => [
                'description' => 'Return number of resources',
                'httpVerb' => 'GET',
                'name' => 'count',
                'options' => [],
                'path' => 'count',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'findOne' => [
                'description' => 'Find resources',
                'httpVerb' => 'GET',
                'name' => 'findOne',
                'options' => [],
                'path' => 'findOne',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'find' => [
                'description' => 'Find resources',
                'httpVerb' => 'GET',
                'name' => 'find',
                'options' => [],
                'path' => '',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'deleteById' => [
                'description' => 'Delete resource by ID',
                'httpVerb' => 'DELETE',
                'name' => 'deleteById',
                'options' => [],
                'path' => '{id}',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'updateProperties' => [
                'description' => 'Update resource properties by ID',
                'httpVerb' => 'PUT',
                'name' => 'updateProperties',
                'options' => [],
                'path' => '{id}',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
            'findById' => [
                'description' => 'Find resource by ID',
                'httpVerb' => 'GET',
                'name' => 'findById',
                'options' => [],
                'path' => '{id}',
                'preServiceNames' => [],
                'preServiceOptions' => [],
                'preServicePriority' => [],
                'postServiceNames' => [],
                'postServiceOptions' => [],
                'postServicePriority' => [],
            ],
        ],
        'methodPriority' => [
        ],
        /* Resource Options */
        'options' => [],
        /* Pre Controller Middleware  */
        /*
         * '{serviceAlias}' => '{serviceName}',
         */
        'preServiceNames' => [
            'JsonRequestFormat' => 'Reliv\PipeRat\Middleware\RequestFormat\JsonRequestFormat',
        ],
        /*
         * '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ],
         */
        'preServiceOptions' => [
        ],
        /*
         * '{serviceAlias}' => {priority},
         */
        'preServicePriority' => [
            'JsonRequestFormat' => 1000,
        ],
        /*
         * '{serviceAlias}' => '{serviceName}',
         */
        'postServiceNames' => [
            'JsonResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
            'XmlResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat',
            'DefaultResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
        ],
        /*
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
            'JsonRequestFormat' => 1000,
            'XmlResponseFormat' => 900,
            'DefaultResponseFormat' => 800
        ],
    ],
    /**
     *
     */
    'resources' => [
    ],
    /* DEFAULT: Route */
    'routeServiceNames' => [
        'baseRoute' => 'Reliv\PipeRat\Middleware\Router',
    ],
    'routeServiceOptions' => [],
    'routeServicePriority' => [],
    /* DEFAULT: Error Handlers */
    'errorServiceNames' => [
        'errorHandler' => 'Reliv\PipeRat\Middleware\Error\TriggerErrorHandler',
    ],
    'errorServicePriority' => [],
];

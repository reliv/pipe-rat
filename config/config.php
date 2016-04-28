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

        /**
         * === DEFAULT: Resource Controller ===
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
         * === DEFAULT: Resource Controller Method Definitions ===
         * Methods:
         * '{name}' => [
         *   'description' => 'Create new resource',
         *   'httpVerb' => 'POST',
         *   'name' => 'create',
         *   // '{optionKey}' => '{optionValue}'
         *   'options' => [],
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
        'methods' => [
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
        // '{method}' => {priority}
        'methodPriority' => [
        ],

        /**
         * === DEFAULT: Resource Options ===
         */
        'options' => [],

        /**
         * === DEFAULT: Resource Pre-Services ===
         */
        // '{serviceAlias}' => '{serviceName}'
        'preServiceNames' => [
            'JsonRequestFormat' => 'Reliv\PipeRat\Middleware\RequestFormat\JsonRequestFormat',
        ],
        // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
        'preServiceOptions' => [
        ],
        // '{serviceAlias}' => {priority}
        'preServicePriority' => [
            'JsonRequestFormat' => 1000,
        ],
        
        /**
         * === DEFAULT: Resource Post-Services ===
         */
        //'{serviceAlias}' => '{serviceName}'
        'postServiceNames' => [
            'JsonResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
            'XmlResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\XmlResponseFormat',
            'DefaultResponseFormat' => 'Reliv\PipeRat\Middleware\ResponseFormat\JsonResponseFormat',
        ],
        // '{serviceAlias}' => [ '{optionKey}' => '{optionValue}' ]
        'postServiceOptions' => [
            'DefaultResponseFormat' => [
                'accepts' => [
                    '*/*'
                ],
            ],
        ],
        // '{serviceAlias}' => {priority}
        'postServicePriority' => [
            'JsonRequestFormat' => 1000,
            'XmlResponseFormat' => 900,
            'DefaultResponseFormat' => 800
        ],
    ],

    /**
     * === DEFAULT: Resource Options ===
     * These should be defined by the application
     */
    'resources' => [
    ],

    /**
     * === DEFAULT: Router ===
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
     * === DEFAULT: Error Handlers ===
     */
    'errorServiceNames' => [
        'errorHandler' => 'Reliv\PipeRat\Middleware\Error\TriggerErrorHandler',
    ],
    // '{serviceAlias}' => {priority}
    'errorServicePriority' => [],
];

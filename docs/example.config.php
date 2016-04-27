<?php
/**
 * example.config.php
 */
[
    'resources' => [
        'example-path' => [
            /* Methods White-list */
            'methodsAllowed' => [
                //Reads
                'count',
                'exists',
                'findById',
                'findOne',
                'find',
                //Writes
//                'upsert',
            ],
            'methods' => [],
            /* Resource Controller */
            'controllerServiceName' => 'Reliv\PipeRat\ResourceController\DoctrineResourceController',
            'controllerServiceOptions' => [
                'entity' => 'Rcm\Entity\Country',
            ],
            /* Path */
            'path' => 'example-path',
            /* Pre Controller Middleware */
            'preServiceNames' => [
                //'RcmUserAcl' => 'Reliv\PipeRat\Middleware\Acl\RcmUserAcl',
                //'ZfInputFilterClass' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterClass',
                //'ZfInputFilterConfig' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterConfig',
                //'ZfInputFilterService' => 'Reliv\PipeRat\Middleware\InputFilter\ZfInputFilterService',
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
        ],
    ]
];

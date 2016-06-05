<?php

return array(
    'cdicrm_options' => array(
        'asd' => ''
    ),
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'cdicrm_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CdiCrm/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiCrm\Entity' => 'cdicrm_entity',
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CdiCrm\Controller\Index' => 'CdiCrm\Controller\IndexController',
            'CdiCrm\Controller\Qc' => 'CdiCrm\Controller\QcController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cdicrm' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cdicrm' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/cdicrm',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CdiCrm\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/:controller[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'qc' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/qc',
                            'defaults' => array(
                                '__NAMESPACE__' => 'CdiCrm\Controller',
                                'controller' => 'CdiCrm\Controller\Qc',
                                'action' => 'list',
                            ),
                        ),
                        'child_routes' => array(
                            'list' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/list',
                                    'defaults' => array(
                                        '__NAMESPACE__' => 'CdiCrm\Controller',
                                        'controller' => 'CdiCrm\Controller\Qc',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);



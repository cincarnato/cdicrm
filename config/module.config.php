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
                'type' => 'segment',
                'options' => array(
                    'route' => '/cdicrm/:controller[/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiCrm\Controller\Index',
                        'action' => 'hello',
                    ),
                ),
            ),
        ),
    ),
);



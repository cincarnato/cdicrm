<?php

return array(
    'cditicket_options' => array(
        'asd' => ''
    ),
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'cditicket_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CdiTicket/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'CdiTicket\Entity' => 'cditicket_entity',
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'CdiTicket\Controller\Index' => 'CdiTicket\Controller\IndexController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'cditicket' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'cditicket' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/cditicket/:controller[/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'CdiTicket\Controller\Index',
                        'action' => 'hello',
                    ),
                ),
            ),
        ),
    ),
);



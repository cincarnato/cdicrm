<?php

/**
 * User: Cristian Incarnato
 */
use Zend\ServiceManager\ServiceLocatorInterface;

return array(
    'invokables' => array(
    ),
    'factories' => array(
        'cdicrm_options' => function (ServiceLocatorInterface $sm) {
            $config = $sm->get('Config');
            return new \CdiCommons\Options\CdiCommonsOptions(isset($config['cdicommons_options']) ? $config['cdicommons_options'] : array());
        },
        'cdicrm_get' => function (ServiceLocatorInterface $sm) {
            $service = "";
            return $service;
        }
        ));


        

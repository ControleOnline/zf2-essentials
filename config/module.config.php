<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'ZF2Essentials\Controller\Default' => 'ZF2Essentials\Controller\DefaultController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'default' => array(
                'type' => 'ZF2Essentials\ZF2Essentials',
                'options' => array(
                    'route' => '/[:module][/:controller[/:action]]',
                    'constraints' => array(
                        'module' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'module' => 'ZF2Essentials',
                        'controller' => 'Default',
                        'action' => 'index',
                    ),
                ),
            )
        )
    ),
    // Doctrine configuration
    'doctrine' => array(
        'driver' => array(
            'Entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(getcwd() . DIRECTORY_SEPARATOR . 'entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Entity' => 'Entity'
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

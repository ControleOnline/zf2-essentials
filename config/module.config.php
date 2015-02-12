<?php

return array(
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
                        'module' => 'Default',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
            )
        )
    ),
    // Doctrine configuration
    'doctrine' => array(
        'driver' => array(
            'Entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(getcwd() . DIRECTORY_SEPARATOR . 'entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Entities' => 'Entities'
                ),
            ),
        ),
    ),
);

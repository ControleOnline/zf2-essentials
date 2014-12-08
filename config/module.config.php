<?php

return array(
    'router' => array(
        'routes' => array(
            'default' => array(
                'type' => '\ZF2Essentials\Router',
                'options' => array(
                    'route' => '/[:module][/:controller[/:action]]',
                    'constraints' => array(
                        'module' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'module' => 'default',
                        'controller' => 'index',
                        'action' => 'index',
                    ),
                ),
            )
        )
    ),
);

<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'database' => 'User\Service\Factory\DbAdapterFactory',
            'entity-manager' => 'User\Service\Factory\EntityManager',
        ),
        'invokables' => array(
            'user-entity' => 'User\Model\Entity\User'
        ),
        'shared' => array(
            'user-entity' => false,
        )
    ),
    'doctrine' => array(
        'entity_path' => array(
            __DIR__ . '/../src/User/Model/Entity',
        ),
    ),
    'table-gateway' => array(
        'map' => array(
            'users' => 'User\Model\User',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'User\Controller\Account' => 'User\Controller\AccountController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/user',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Account',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'User' => __DIR__ . '/../view',
        ),
    ),
);

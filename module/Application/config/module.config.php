<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],

    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Factions',
                'route' => 'faction',
                'pages' => [
                    [
                        'label'  => 'List',
                        'route'  => 'faction',
                        'action' => 'index',
                    ],
                    [
                        'label'  => 'Show',
                        'route'  => 'faction',
                        'action' => 'show',
                    ],
                ],
            ],
            [
                'label' => 'Races',
                'route' => 'race',
                'pages' => [
                    [
                        'label'  => 'List',
                        'route'  => 'race',
                        'action' => 'index',
                    ],
                    /*[
                        'label'  => 'Find',
                        'route'  => 'race',
                        'action' => 'find',
                    ],*/
                    [
                        'label'  => 'Show',
                        'route'  => 'race',
                        'action' => 'show',
                    ],
                    /*[
                        'label'  => 'Match',
                        'route'  => 'race',
                        'action' => 'match',
                    ],*/
                ],
            ],
            [
                'label' => 'Items',
                'route' => 'item',
                'pages' => [
                    [
                        'label'  => 'List',
                        'route'  => 'item',
                        'action' => 'index',
                    ],
                    /*[
                        'label'  => 'Find',
                        'route'  => 'item',
                        'action' => 'find',
                    ],*/
                    [
                        'label'  => 'Show',
                        'route'  => 'item',
                        'action' => 'show',
                    ],
                    /*[
                        'label'  => 'Match',
                        'route'  => 'item',
                        'action' => 'match',
                    ],*/
                ],
            ],
            [
                'label' => 'Players',
                'route' => 'player',
                'pages' => [
                    [
                        'label'  => 'List',
                        'route'  => 'player',
                        'action' => 'index',
                    ],
                    /*[
                        'label'  => 'Find',
                        'route'  => 'player',
                        'action' => 'find',
                    ],*/
                    [
                        'label'  => 'Show',
                        'route'  => 'player',
                        'action' => 'show',
                    ],
                    /*[
                        'label'  => 'Match',
                        'route'  => 'player',
                        'action' => 'match',
                    ],*/
                ],
            ],
        ],
    ],

    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

<?php
namespace SourceCraft;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            Model\RaceInterface::class => Model\RaceDbSqlRepository::class,
            Model\RaceRepositoryInterface::class => Model\RaceDbSqlRepository::class,
        ],
        'factories' => [
            Controller\RaceController::class => Factory\RaceControllerFactory::class,
            Model\RaceDbSqlRepository::class => Factory\RaceDbSqlRepositoryFactory::class,
            Model\RaceRepository::class => InvokableFactory::class,
        ],
    ],

    /**/
    'controllers' => [
        'factories' => [
            Model\RaceRepository::class => InvokableFactory::class,
            Controller\RaceController::class => Factory\RaceControllerFactory::class,
        ],
    ],
	/**/

    'router' => [
        'routes' => [
            'faction' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/race[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\RaceController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'race' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/race[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\RaceController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'race' => __DIR__ . '/../view',
        ],
    ],
];
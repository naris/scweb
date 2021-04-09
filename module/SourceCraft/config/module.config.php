<?php
namespace SourceCraft;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'aliases' => [
            Model\RaceRepositoryInterface::class => Model\RaceDbSelect::class,
            Model\UpgradeRepositoryInterface::class => Model\UpgradeDbSelect::class,
            Model\FactionRepositoryInterface::class => Model\FactionDbSelect::class,
        ],
        'factories' => [
            Model\RaceRepository::class => InvokableFactory::class,
            Model\RaceDbSelect::class => Factory\RaceDbSelectFactory::class,
            Controller\RaceController::class => Factory\RaceControllerFactory::class,

            Model\UpgradeDbSelect::class => Factory\UpgradeDbSelectFactory::class,

            Model\FactionRepository::class => InvokableFactory::class,
            Model\FactionDbSelect::class => Factory\FactionDbSelectFactory::class,
            Controller\FactionController::class => Factory\FactionControllerFactory::class,
        ],
    ],

    /**/
    'controllers' => [
        'factories' => [
            Model\RaceRepository::class => InvokableFactory::class,
            Controller\RaceController::class => Factory\RaceControllerFactory::class,

            Model\FactionRepository::class => InvokableFactory::class,
            Controller\FactionController::class => Factory\FactionControllerFactory::class,
        ],
    ],
	/**/

    'router' => [
        'routes' => [
            'faction' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/faction[/:action[/:id][/name/:name]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        /*'id'     => '(Terran|Protoss|Zerg|HumanAlliance|OrcishHorde|NightElf|UndeadScourge|BurningLegion|Hellbourne|TheLegion|Sentinel|Naga|Titan|XelNaga|Pony)',*/
                        'id'     => '[A-Z][a-zA-Z0-9_-]+',
                        'name'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\FactionController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'race' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/race[/:action[/:id][/name/:name]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'name'   => '[a-zA-Z][a-zA-Z0-9_-]*',
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
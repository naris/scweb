<?php
namespace SourceCraft;

use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\RaceTable::class => function($container) {
                    $tableGateway = $container->get(Model\RaceTableGateway::class);
                    return new Model\RaceTable($tableGateway);
                },
                Model\RaceTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Race());
                    return new TableGateway('sc_races', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\RaceController::class => function($container) {
                    return new Controller\RaceController(
                        $container->get(Model\RaceDbSelect::class)
                    );
                },
                Controller\FactionController::class => function($container) {
                    return new Controller\FactionController(
                        $container->get(Model\FactionDbSelect::class)
                    );
                },
            ],
        ];
    }
}
<?php
// In /module/SourceCraft/src/Factory/PlayerControllerFactory.php:
namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Controller\PlayerController;
use SourceCraft\Model\PlayerDbInterface;
use SourceCraft\Model\PlayerAliasDbInterface;

use SourceCraft\Controller\RaceController;
use SourceCraft\Model\RaceDbInterface;
use SourceCraft\Model\UpgradeDbInterface;

class PlayerControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return PlayerController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PlayerController($container->get(PlayerDbInterface::class),
                                    $container->get(RaceDbInterface::class),
                                    $container->get(UpgradeDbInterface::class),
                                    $container->get(PlayerAliasDbInterface::class));
    }
}
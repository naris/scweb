<?php
// In /module/SourceCraft/src/Factory/FactionControllerFactory.php:
namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Controller\FactionController;
use SourceCraft\Model\FactionDbInterface;
use SourceCraft\Model\RaceDbInterface;

class FactionControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return FactionController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FactionController($container->get(FactionDbInterface::class),
                                     $container->get(RaceDbInterface::class));
    }
}
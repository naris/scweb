<?php
// In /module/SourceCraft/src/Factory/RaceControllerFactory.php:
namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Controller\RaceController;
use SourceCraft\Model\RaceRepositoryInterface;

class RaceControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return RaceController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RaceController($container->get(RaceRepositoryInterface::class));
    }
}
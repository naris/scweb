<?php
// In module/SourceCraft/src/Factory/PlayerDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\PlayerTech;
use SourceCraft\Model\PlayerTechDbSelect;

class PlayerTechDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return PlayerTechDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PlayerTechDbSelect($container->get(AdapterInterface::class),
                                        new ReflectionHydrator(),
                                        new PlayerTech());
    }
}
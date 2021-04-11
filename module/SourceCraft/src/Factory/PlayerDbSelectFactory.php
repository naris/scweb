<?php
// In module/SourceCraft/src/Factory/PlayerDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\Player;
use SourceCraft\Model\PlayerDbSelect;

class PlayerDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return PlayerDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PlayerDbSelect($container->get(AdapterInterface::class),
                                  new ReflectionHydrator(),
                                  new Player());
    }
}
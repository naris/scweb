<?php
// In module/SourceCraft/src/Factory/PlayerDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\PlayerAlias;
use SourceCraft\Model\PlayerAliasDbSelect;

class PlayerAliasDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return PlayerAliasDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new PlayerAliasDbSelect($container->get(AdapterInterface::class),
                                        new ReflectionHydrator(),
                                        new PlayerAlias());
    }
}
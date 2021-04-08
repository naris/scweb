<?php
// In module/SourceCraft/src/Factory/FactionDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\Faction;
use SourceCraft\Model\FactionDbSelect;

class FactionDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return FactionDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new FactionDbSelect($container->get(AdapterInterface::class),
        new ReflectionHydrator(),
        new Faction());
    }
}
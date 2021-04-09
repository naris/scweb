<?php
// In module/SourceCraft/src/Factory/UpgradeDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\Upgrade;
use SourceCraft\Model\UpgradeDbSelect;

class UpgradeDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return UpgradeDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new UpgradeDbSelect($container->get(AdapterInterface::class),
        new ReflectionHydrator(),
        new Upgrade());
    }
}
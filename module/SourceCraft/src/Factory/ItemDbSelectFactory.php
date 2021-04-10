<?php
// In module/SourceCraft/src/Factory/ItemDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\Item;
use SourceCraft\Model\ItemDbSelect;

class ItemDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ItemDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ItemDbSelect($container->get(AdapterInterface::class),
        new ReflectionHydrator(),
        new Item());
    }
}
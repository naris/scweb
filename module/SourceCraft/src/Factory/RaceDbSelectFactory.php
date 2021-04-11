<?php
// In module/SourceCraft/src/Factory/RaceDbSelectFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\Race;
use SourceCraft\Model\RaceDbSelect;

class RaceDbSelectFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return RaceDbSelect
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RaceDbSelect($container->get(AdapterInterface::class),
                                new ReflectionHydrator(),
                                new Race());
    }
}
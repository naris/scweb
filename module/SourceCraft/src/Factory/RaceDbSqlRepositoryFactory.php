<?php
// In module/SourceCraft/src/Factory/RaceDbSqlRepositoryFactory.php

namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Model\Race;
use SourceCraft\Model\RaceDbSqlRepository;

class RaceDbSqlRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return RaceDbSqlRepository
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RaceDbSqlRepository($container->get(AdapterInterface::class),
        new ReflectionHydrator(),
        new Race());
    }
}
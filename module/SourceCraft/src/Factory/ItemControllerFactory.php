<?php
// In /module/SourceCraft/src/Factory/ItemControllerFactory.php:
namespace SourceCraft\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

use SourceCraft\Controller\ItemController;
use SourceCraft\Model\ItemDbInterface;

class ItemControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return ItemController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new ItemController($container->get(ItemDbInterface::class));
    }
}
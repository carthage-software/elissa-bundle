<?php

declare(strict_types=1);

namespace Carthage\ElissaBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class ElissaExtension implements ExtensionInterface
{
    public function __construct(
        private readonly string $alias,
    ) {
    }

    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../resources/config'));
        $loader->load('services.xml');
    }

    public function getNamespace(): string
    {
        return 'https://carthage.software/schema/dic/elissa';
    }

    public function getXsdValidationBasePath(): string
    {
        return __DIR__ . '/../../resources/schema/';
    }

    public function getAlias(): string
    {
        return $this->alias;
    }
}

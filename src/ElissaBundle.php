<?php

declare(strict_types=1);

namespace Carthage\ElissaBundle;

use Carthage\ElissaBundle\DependencyInjection\ElissaExtension;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class ElissaBundle extends Bundle
{
    private const ALIAS = 'elissa';

    public function __construct(
        private readonly string $alias = self::ALIAS,
    ) {
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->registerForAutoconfiguration(RequestHandlerInterface::class)
            ->addTag('controller.service_arguments');

        $container->registerForAutoconfiguration(MiddlewareInterface::class)
            ->addTag('elissa.middleware')
        ;
    }

    public function getContainerExtension(): ExtensionInterface
    {
        return new ElissaExtension($this->alias);
    }

    protected function getContainerExtensionClass(): string
    {
        return ElissaExtension::class;
    }

    public function getPath(): string
    {
        return __DIR__;
    }
}

<?php

namespace App\Infrastructure\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\Infrastructure\Representation\RepresentationInterface;
use App\Infrastructure\Representation\RepresentationFactoryInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;

/**
 * Class RepresentationPass
 * @package App\Infrastructure\DependencyInjection\Compiler
 */
class RepresentationPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $representationFactory = $container->findDefinition(RepresentationFactoryInterface::class);

        $representation = $container->findDefinition(RepresentationInterface::class);
        $representation->setShared(false);

        $paginators = $container->findTaggedServiceIds("app.paginator");

        $serviceMap = [
            RepresentationInterface::class => new Reference($representation->getClass())
        ];

        foreach ($paginators as $id => $taggedId) {
            $serviceMap[$container->getDefinition($id)->getClass()] = new Reference($id);
        }

        $representationFactory->setArgument(0, ServiceLocatorTagPass::register($container, $serviceMap));
    }
}
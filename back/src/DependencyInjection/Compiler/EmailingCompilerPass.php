<?php

declare(strict_types=1);

namespace Emailing\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Emailing\Domain\Command\CrudResourceChain;
use Emailing\Domain\Query\DataProvider\CollectionDataProviderChain;
use Emailing\Domain\Query\DataProvider\ItemDataProviderChain;

class EmailingCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ItemDataProviderChain::class)) {
            return;
        }

        if (!$container->has(CrudResourceChain::class)) {
            return;
        }

        if (!$container->has(CollectionDataProviderChain::class)) {
            return;
        }

        $dataProviderDefinition = $container->findDefinition(ItemDataProviderChain::class);
        $collectionDataProviderDefinition = $container->findDefinition(CollectionDataProviderChain::class);
        $cruResourceDefinition = $container->findDefinition(CrudResourceChain::class);

        $taggedServices = $container->findTaggedServiceIds('sympl.mail_handler');
        $crudTaggedServices = $container->findTaggedServiceIds('sympl.mail_crud_resource');
        $collectionProvidersTagsServices = $container->findTaggedServiceIds('sympl.mail_Collection_handler');

        foreach ($taggedServices as $id => $tags) {
            $dataProviderDefinition->addMethodCall('addHandler', [new Reference($id)]);
        }

        foreach ($crudTaggedServices as $id => $tags) {
            $cruResourceDefinition->addMethodCall('addHandler', [new Reference($id)]);
        }

        foreach ($collectionProvidersTagsServices as $id => $tags) {
            $collectionDataProviderDefinition->addMethodCall('addHandler', [new Reference($id)]);
        }
    }
}

<?php

namespace ONGR\ElasticsearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ManagerPass implements CompilerPassInterface
{
    const TAG_NAME = 'es.manager';

    public function process(ContainerBuilder $container)
    {
        $managers = [];
        $taggedServices = $container->findTaggedServiceIds(self::TAG_NAME);
        foreach ($taggedServices as $key => $ids) {
            $managers[$key] = $container->getDefinition($key);
        }

        $container->getDefinition('es.command.cache_clear')->setArgument('$managers', $managers);
        $container->getDefinition('es.command.document_generate')->setArgument('$managers', $managers);
        $container->getDefinition('es.command.index_create')->setArgument('$managers', $managers);
        $container->getDefinition('es.command.index_export')->setArgument('$managers', $managers);
        $container->getDefinition('es.command.index_import')->setArgument('$managers', $managers);
        $container->getDefinition('es.command.index_drop')->setArgument('$managers', $managers);
    }
}

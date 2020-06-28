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

        $this->addManagers($container, 'es.command.cache_clear', $managers);
        $this->addManagers($container, 'es.command.document_generate', $managers);
        $this->addManagers($container, 'es.command.index_create', $managers);
        $this->addManagers($container, 'es.command.index_export', $managers);
        $this->addManagers($container, 'es.command.index_import', $managers);
        $this->addManagers($container, 'es.command.index_drop', $managers);
    }

    private function addManagers(ContainerBuilder $container, $definitionName, array $managers)
    {
        $definition = $container->getDefinition($definitionName);

        if (method_exists($definition, 'setArgument')) {
            $definition->setArgument('$managers', $managers);

            return;
        }

        $arguments = $definition->getArguments();
        $arguments[] = $managers;

        $definition->setArguments($arguments);
    }
}

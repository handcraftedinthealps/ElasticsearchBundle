<?php

namespace ONGR\ElasticsearchBundle\DependencyInjection\Compiler;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @internal
 */
class AnnotationReaderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition('es.annotations.reader')) {
            return;
        }

        $definition = new Definition(AnnotationReader::class);
        $definition->addMethodCall('addGlobalIgnoredName', ['required']);
        $container->setDefinition('es.annotations.reader', $definition);
    }
}

<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Kernel;

/**
 * Compiles elastic search data.
 */
class RepositoryPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $managers = $container->getParameter('es.managers');

        $removeContainerBuildId = false;
        if (!$container->hasParameter('container.build_id')) {
            // the 'container.build_id' is required for `es.cache_engine` system cache which normally can not
            // be constructor inside a compiler pass. This is a workaround to make it work.
            // see also:
            //     - https://github.com/symfony/symfony/blob/52a92926f7fed15cdff399c6921100a10e0d6f61/src/Symfony/Component/DependencyInjection/Dumper/PhpDumper.php#L389
            //     - https://github.com/symfony/symfony/blob/52a92926f7fed15cdff399c6921100a10e0d6f61/src/Symfony/Bundle/FrameworkBundle/DependencyInjection/FrameworkExtension.php#L2322
            $container->setParameter('container.build_id', hash('crc32', 'Abc123' . time()));
            $removeContainerBuildId = true;
        }

        $collector = $container->get('es.metadata_collector');
        if ($removeContainerBuildId) {
            $container->getParameterBag()->remove('container.build_id');
        }

        foreach ($managers as $managerName => $manager) {
            $mappings = $collector->getMappings($manager['mappings']);

            // Building repository services.
            foreach ($mappings as $repositoryType => $repositoryDetails) {
                $repositoryDefinition = new Definition(
                    'ONGR\ElasticsearchBundle\Service\Repository',
                    [$repositoryDetails['namespace']]
                );
                $repositoryDefinition->setPublic(true);

                if (isset($repositoryDetails['directory_name']) && $managerName == 'default') {
                    $container->get('es.document_finder')->setDocumentDir($repositoryDetails['directory_name']);
                }

                $repositoryDefinition->setFactory(
                    [
                        new Reference(sprintf('es.manager.%s', $managerName)),
                        'getRepository',
                    ]
                );

                $repositoryId = sprintf('es.manager.%s.%s', $managerName, $repositoryType);
                $container->setDefinition($repositoryId, $repositoryDefinition);
            }
        }
    }
}

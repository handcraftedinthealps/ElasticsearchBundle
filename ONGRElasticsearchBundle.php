<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle;

use ONGR\ElasticsearchBundle\DependencyInjection\Compiler\ManagerPass;
use ONGR\ElasticsearchBundle\DependencyInjection\Compiler\MappingPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * ONGR Elasticsearch bundle system file required by kernel.
 */
class ONGRElasticsearchBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // MappingPass need to be behind the Symfony `DecoratorServicePass` to allow decorating the annotation reader
        $container->addCompilerPass(new MappingPass(), PassConfig::TYPE_OPTIMIZE, -10);
        $container->addCompilerPass(new ManagerPass(), PassConfig::TYPE_OPTIMIZE, -11);
    }
}

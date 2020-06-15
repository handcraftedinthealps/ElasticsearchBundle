<?php

namespace ONGR\ElasticsearchBundle\Tests\Functional\Command;

use ONGR\ElasticsearchBundle\Command\DocumentGenerateCommand;
use ONGR\ElasticsearchBundle\Tests\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateDocumentCommandTest extends WebTestCase
{
    /**
     * Tests if exception is thrown when no interaction is set
     */
    public function testExecuteException()
    {
        $this->expectException(\InvalidArgumentException::class);

        $app = new Application();
        $app->add($this->getCommand());

        $command = $app->find('ongr:es:document:generate');

        $tester = new CommandTester($command);
        $tester->execute(['command' => $command->getName()], ['interactive' => false]);
        $tester->execute(
            ['command' => $command->getName(), '--no-interaction' => true],
            ['interactive' => false]
        );
    }

    /**
     * @return DocumentGenerateCommand
     */
    private function getCommand()
    {
        $container = self::createClient()->getContainer();

        return new DocumentGenerateCommand(
            $container->getParameter('kernel.bundles'),
            $container->get('es.generate'),
            $container->get('es.metadata_collector'),
            $container->get('es.annotations.cached_reader'),
            ['es.manager.default' => $container->get('es.manager.default')]
        );
    }
}

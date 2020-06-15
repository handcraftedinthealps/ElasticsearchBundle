<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Command;

use ONGR\ElasticsearchBundle\Service\Manager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * AbstractElasticsearchCommand class.
 */
abstract class AbstractManagerAwareCommand extends Command
{
    /**
     * @var Manager[]
     */
    protected $managers;

    public function __construct(array $managers, $name = null)
    {
        parent::__construct($name);
        $this->managers = $managers;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->addOption(
            'manager',
            'm',
            InputOption::VALUE_REQUIRED,
            'Manager name',
            'default'
        );
    }

    /**
     * Returns elasticsearch manager by name from service container.
     *
     * @param string $name Manager name defined in configuration.
     *
     * @return Manager
     *
     * @throws \RuntimeException If manager was not found.
     */
    protected function getManager($name)
    {
        $id = $this->getManagerId($name);

        if (array_key_exists($id, $this->managers)) {
            return $this->managers[$id];
        }

        throw new \RuntimeException(
            sprintf(
                'Manager named `%s` not found. Available: `%s`.',
                $name,
                implode('`, `', array_keys($this->managers))
            )
        );
    }

    /**
     * Formats manager service id from its name.
     *
     * @param string $name Manager name.
     *
     * @return string Service id.
     */
    private function getManagerId($name)
    {
        return sprintf('es.manager.%s', $name);
    }
}

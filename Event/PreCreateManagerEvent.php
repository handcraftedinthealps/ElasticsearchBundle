<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchBundle\Event;

use Elastic\Elasticsearch\ClientBuilder;
use Elasticsearch\ClientBuilder as LegacyClientBuilder;

class PreCreateManagerEvent extends BaseEvent
{
    /**
     * @var ClientBuilder
     */
    private $client;

    /**
     * @var array
     */
    private $indexSettings;

    /**
     * CreateManagerEvent constructor.
     *
     * @param ClientBuilder|LegacyClientBuilder $client
     * @param $indexSettings array
     */
    public function __construct($client, &$indexSettings)
    {
        $this->client = $client;
        $this->indexSettings = $indexSettings;
    }

    /**
     * @return ClientBuilder|LegacyClientBuilder
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param ClientBuilder|LegacyClientBuilder $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function getIndexSettings()
    {
        return $this->indexSettings;
    }

    /**
     * @param array $indexSettings
     */
    public function setIndexSettings($indexSettings)
    {
        $this->indexSettings = $indexSettings;
    }
}

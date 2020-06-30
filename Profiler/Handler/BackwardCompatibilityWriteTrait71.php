<?php

namespace ONGR\ElasticsearchBundle\Profiler\Handler;

/**
 * @internal
 */
trait BackwardCompatibilityWriteTrait71
{
    protected function write(array $record)
    {
        $this->doWrite($record);
    }
}

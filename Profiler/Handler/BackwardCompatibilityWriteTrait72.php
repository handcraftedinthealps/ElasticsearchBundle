<?php

namespace ONGR\ElasticsearchBundle\Profiler\Handler;

/**
 * @internal
 */
trait BackwardCompatibilityWriteTrait72
{
    protected function write(array $record): void
    {
        $this->doWrite($record);
    }
}

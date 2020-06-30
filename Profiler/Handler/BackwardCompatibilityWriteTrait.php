<?php

namespace ONGR\ElasticsearchBundle\Profiler\Handler;

if (PHP_VERSION_ID >= 70200) {
    /**
     * @internal
     */
    trait BackwardCompatibilityWriteTrait
    {
        use BackwardCompatibilityWriteTrait72;
    }
} else {
    /**
     * @internal
     */
    trait BackwardCompatibilityWriteTrait
    {
        use BackwardCompatibilityWriteTrait71;
    }
}

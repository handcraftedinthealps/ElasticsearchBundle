<?php
// @codingStandardsIgnoreStart

namespace ONGR\ElasticsearchBundle\Profiler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

if (PHP_VERSION_ID < 72000) {
    trait CollectTrait
    {
        public function collect(Request $request, Response $response, \Exception $exception = null)
        {
            return $this->doCollect($request, $response, $exception);
        }
    }
} else {
    trait CollectTrait
    {
        public function collect(Request $request, Response $response, $exception = null)
        {
            return $this->doCollect($request, $response, $exception);
        }
    }
}
// @codingStandardsIgnoreEnd

<?php
// @codingStandardsIgnoreStart

namespace ONGR\ElasticsearchBundle\Profiler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;

if (Kernel::VERSION_ID <= 40410) {
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
        public function collect(Request $request, Response $response, \Throwable $exception = null)
        {
            return $this->doCollect($request, $response, $exception);
        }
    }
}
// @codingStandardsIgnoreEnd

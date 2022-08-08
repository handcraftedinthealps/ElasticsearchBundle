<?php
namespace ONGR\ElasticsearchBundle\Tests;

class WebTestCase extends \Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    #[\ReturnTypeWillChange] public static function getKernelClass(): string /*
    public static function getKernelClass() /* PHP<8 */
    { // @codingStandardsIgnoreLine
        require_once __DIR__.'/app/AppKernel.php';

        return \AppKernel::class;
    }
}

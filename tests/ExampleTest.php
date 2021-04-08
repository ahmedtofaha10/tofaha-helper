<?php

namespace Tofaha\Helper\Tests;

use Orchestra\Testbench\TestCase;
use Tofaha\Helper\HelperServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [HelperServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}

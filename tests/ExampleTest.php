<?php

namespace Leshkens\LaravelReadtime\Tests;

use Orchestra\Testbench\TestCase;
use Leshkens\LaravelReadtime\LaravelReadtimeServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelReadtimeServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}

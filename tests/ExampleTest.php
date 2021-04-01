<?php

declare(strict_types=1);

namespace Leshkens\LaravelReadtime\Tests;

use Orchestra\Testbench\TestCase;
use Leshkens\LaravelReadtime\Providers\ReadtimeServiceProvider;

/**
 * Class ExampleTest
 *
 * @package Leshkens\LaravelReadtime\Tests
 */
class ExampleTest extends TestCase
{
    /**
     * @param $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [ReadtimeServiceProvider::class];
    }

    /** @test */
    public function true_is_true(): void
    {
        $this->assertTrue(true);
    }
}

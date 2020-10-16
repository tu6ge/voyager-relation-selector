<?php

namespace VoyagerRelationSelector\Tests;

use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        //$this->app->resolved()
    }

    public function getPackageProviders($app)
    {
        return [
            'TCG\Voyager\VoyagerServiceProvider',
            'VoyagerRelationSelector\VoyagerRelationSelectorServiceProvider',
        ];
    }
}

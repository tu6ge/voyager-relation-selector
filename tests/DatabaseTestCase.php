<?php

namespace VoyagerRelationSelector\Tests;

use Illuminate\Support\Facades\DB;

class DatabaseTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();

        $this->loadMigrationsFrom('./vendor/tcg/voyager/migrations');

        $this->seed(\VoyagerDatabaseSeeder::class);

        $this->loadMigrationsFrom('./database/migrations');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations/');
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function tearDown(): void
    {
        DB::table('foo')->whereRaw(1)->delete();
    }
}

<?php

namespace Sashalenz\NovaActivitylog\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sashalenz\NovaActivitylog\ToolServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ToolServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        /*
        include_once __DIR__.'/../database/migrations/create_nova_activitylog_table.php.stub';
        (new \CreatePackageTable())->up();
        */
    }
}

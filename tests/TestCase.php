<?php

namespace LaravelLookbook\Tests;

use LaravelLookbook\LookbookServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
  protected function getPackageProviders($app)
  {
    return [
      LookbookServiceProvider::class,
    ];
  }

  protected function defineEnvironment($app)
  {
    $app['config']->set('lookbook.component_directory', __DIR__ . '/fixtures/components');
  }
}

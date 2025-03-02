<?php

namespace LaravelLookbook\Tests\Fixtures;

use LaravelLookbook\Support\ComponentPreview;

class TestComponent extends ComponentPreview
{
  static public function getName()
  {
    return 'Test Component';
  }

  public function default()
  {
    return '<div>Test Component</div>';
  }
}

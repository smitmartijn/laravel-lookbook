<?php

namespace LaravelLookbook\Tests\Unit;

use LaravelLookbook\Tests\TestCase;
use LaravelLookbook\Lookbook;
use LaravelLookbook\Support\ComponentFinder;
use LaravelLookbook\Support\ComponentRenderer;

class LookbookTest extends TestCase
{
  protected Lookbook $lookbook;

  protected function setUp(): void
  {
    parent::setUp();
    $this->lookbook = new Lookbook();
  }

  public function test_can_get_components()
  {
    $this->mock(ComponentFinder::class)
      ->shouldReceive('getComponents')
      ->once()
      ->andReturn(['test-component']);

    $components = $this->lookbook->components();

    $this->assertEquals(['test-component'], $components);
  }

  public function test_can_render_component()
  {
    $this->mock(ComponentRenderer::class)
      ->shouldReceive('render')
      ->with('test-component')
      ->once()
      ->andReturn('<div>Test Component</div>');

    $rendered = $this->lookbook->renderComponent('test-component');

    $this->assertEquals('<div>Test Component</div>', $rendered);
  }
}

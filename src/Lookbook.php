<?php

namespace LaravelLookbook;

class Lookbook
{
  /**
   * Get the registered components.
   *
   * @return array
   */
  public function components()
  {
    return app(Support\ComponentFinder::class)->getComponents();
  }

  /**
   * Render a component preview.
   *
   * @param string $component
   * @return string
   */
  public function renderComponent($component)
  {
    return app(Support\ComponentRenderer::class)->render($component);
  }
}

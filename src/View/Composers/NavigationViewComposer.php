<?php

namespace LaravelLookbook\View\Composers;

use Illuminate\View\View;
use LaravelLookbook\Support\ComponentFinder;

class NavigationViewComposer
{
  protected $componentFinder;

  public function __construct(ComponentFinder $componentFinder)
  {
    $this->componentFinder = $componentFinder;
  }

  public function compose(View $view)
  {
    $allComponents = $this->componentFinder->findComponents();

    // Get full path from route including any parameters
    $activeComponentPath = request()->route('component') ?? '';

    // Normalize current path to match component path format
    $activeComponentPath = str_replace('\\', '/', $activeComponentPath);

    $tree = [
      'root' => [
        'components' => collect([]),
        'children' => [],
        'depth' => 0,
        'name' => ''
      ]
    ];

    foreach ($allComponents as $component) {
      $categories = $component['category'];

      if (empty($categories)) {
        $tree['root']['components']->push($component);
        continue;
      }

      $current = &$tree;
      $pathParts = [];

      foreach ($categories as $category) {
        $pathParts[] = $category;
        $categoryPath = implode('/', $pathParts);

        // Ensure category exists in current level
        if (!isset($current['children'][$categoryPath])) {
          $current['children'][$categoryPath] = [
            'components' => collect([]),
            'children' => [],
            'depth' => count($pathParts),
            'name' => $category
          ];
        }

        // Move reference to the actual node
        $current = &$current['children'][$categoryPath];
      }

      // Add component to leaf node
      $current['components']->push($component);
    }

    $view->with('navigationTree', $tree);
    $view->with('currentPath', $activeComponentPath);
  }
}

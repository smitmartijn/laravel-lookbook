<?php

namespace LaravelLookbook\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelLookbook\Support\ComponentFinder;
use LaravelLookbook\Support\ComponentRenderer;

class LookbookController extends Controller
{
    protected $componentFinder;
    protected $componentRenderer;

    public function __construct(ComponentFinder $componentFinder, ComponentRenderer $componentRenderer)
    {
        $this->componentFinder = $componentFinder;
        $this->componentRenderer = $componentRenderer;
    }

    public function index()
    {
        $components = $this->componentFinder->findComponents();

        if ($components->isEmpty()) {
            return view('lookbook::empty');
        }

        $firstComponent = $components->first();
        return $this->show($firstComponent['path']);
    }

    public function show($componentPath)
    {
        $component = $this->componentFinder->findComponent($componentPath);

        if (!$component) {
            abort(404, 'Component not found');
        }

        $previews = $this->componentRenderer->render($component);

        return view('lookbook::show', [
            'component' => $component,
            'previews' => $previews,
        ]);
    }
}

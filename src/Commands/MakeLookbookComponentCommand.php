<?php

namespace LaravelLookbook\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeLookbookComponentCommand extends Command
{
  protected $signature = 'make:lookbook-component {name}';
  protected $description = 'Create a new Lookbook component preview';

  public function handle()
  {
    $name = str_replace('\\', '/', $this->argument('name'));
    $path = app_path('Lookbook/' . $name . '.php');
    $directory = dirname($path);

    // Create directory if it doesn't exist
    if (!File::isDirectory($directory)) {
      File::makeDirectory($directory, 0755, true);
    }

    // Generate namespace based on path
    $namespace = 'App\\Lookbook';
    if (dirname($name) !== '.') {
      $namespace .= '\\' . str_replace('/', '\\', dirname($name));
    }

    // Get the class name from the last part of the path
    $className = basename($name);

    // Generate component content
    $content = $this->getStub($namespace, $className);

    // Create the file
    File::put($path, $content);

    $this->info('Lookbook component created successfully in ' . $path);
  }

  protected function getStub($namespace, $className)
  {
    return <<<PHP
<?php

namespace {$namespace};

use LaravelLookbook\Support\ComponentPreview;
use Illuminate\Support\Facades\Blade;

class {$className} extends ComponentPreview
{
    static public function getName()
    {
        return 'Prettier name for {$className}';
    }

    /**
     * @name Default component example
     * @notes This is an example component, please change.
     */
    public function default()
    {
        return (string) Blade::render(<<<'HTML'
<div>
    Example component
</div>
HTML);
    }
}
PHP;
  }
}

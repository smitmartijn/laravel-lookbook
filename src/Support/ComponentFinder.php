<?php

namespace LaravelLookbook\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ComponentFinder
{
    protected $filesystem;
    protected $basePath;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->basePath = config('lookbook.component_directory');
    }

    /**
     * Find all components in the lookbook directory
     *
     * @return Collection
     */
    public function findComponents()
    {
        if (!$this->filesystem->exists($this->basePath)) {
            return collect([]);
        }

        $files = $this->filesystem->allFiles($this->basePath);

        return collect($files)
            ->filter(function ($file) {
                return $file->getExtension() === 'php';
            })
            ->map(function ($file) {
                $relativePath = $this->getRelativePath(
                    $this->basePath,
                    $file->getPath()
                );

                $name = $file->getBasename('.php');
                $path = $relativePath ? "{$relativePath}/{$name}" : $name;
                // Change from single category to array of categories
                $relativePath = $this->getRelativePath($this->basePath, $file->getPath());
                // Instead of just taking first directory as category:
                // $category = $relativePath ? explode('/', $relativePath)[0] : '';
                // We should keep full path structure:
                $categories = $relativePath ? explode('/', $relativePath) : [];
                $className = $this->getClassNameFromFile($file->getPathname());
                if ($className && class_exists($className) && method_exists($className, 'getName')) {
                    $customName = $className::getName();
                    if ($customName) {
                        $name = $customName;
                    }
                }

                return [
                    'name' => $name,
                    'path' => $path,
                    'file' => $file->getPathname(),
                    'category' => $categories,
                    'class' => $className
                ];
            });
    }

    /**
     * Find a specific component by path
     *
     * @param string $path
     * @return array|null
     */
    public function findComponent($path)
    {
        // Normalize path to use forward slashes
        $path = str_replace('\\', '/', $path);

        return $this->findComponents()
            ->first(function ($component) use ($path) {
                return $component['path'] === $path;
            });
    }

    /**
     * Get the path relative to a given base path
     *
     * @param string $basePath
     * @param string $path
     * @return string
     */
    protected function getRelativePath($basePath, $path)
    {
        // Normalize paths to use forward slashes
        $basePath = rtrim(str_replace('\\', '/', $basePath), '/') . '/';
        $path = str_replace('\\', '/', $path);

        if (str_starts_with($path, $basePath)) {
            $relativePath = substr($path, strlen($basePath));
            return $relativePath ?: '';
        }

        return '';
    }

    /**
     * Extract the class name from a PHP file
     *
     * @param string $filePath
     * @return string|null
     */
    protected function getClassNameFromFile($filePath)
    {
        $content = file_get_contents($filePath);
        $namespace = '';
        $className = '';

        // Get namespace
        if (preg_match('/namespace\s+([^;]+);/', $content, $matches)) {
            $namespace = $matches[1];
        }

        // Get class name
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            $className = $matches[1];
        }

        if ($namespace && $className) {
            return $namespace . '\\' . $className;
        } elseif ($className) {
            return $className;
        }

        return null;
    }
}

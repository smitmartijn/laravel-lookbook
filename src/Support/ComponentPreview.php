<?php

namespace LaravelLookbook\Support;

abstract class ComponentPreview
{
  /**
   * Get all preview methods in the class
   *
   * @return array
   */
  public function getPreviews(): array
  {
    $reflectionClass = new \ReflectionClass($this);
    $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);

    $previews = [];

    foreach ($methods as $method) {
      // Skip methods from the parent class
      if ($method->class !== get_class($this)) {
        continue;
      }

      // Skip magic methods and predefined model functions
      if (strpos($method->name, '__') === 0 || in_array($method->name, ['getName', 'getPreview', 'getSourceCode', 'getNotes'])) {
        continue;
      }

      $previews[] = $method->name;
    }

    return $previews;
  }

  /**
   * Get metadata from method docblock
   *
   * @param string $methodName
   * @return array
   */
  public function getPreviewMetadata(string $methodName): array
  {
    $reflectionMethod = new \ReflectionMethod($this, $methodName);
    $docComment = $reflectionMethod->getDocComment();

    $metadata = [
      'name' => $this->formatMethodName($methodName),
      'label' => $this->formatMethodName($methodName),
      'notes' => '',
      'hidden' => false,
    ];

    if ($docComment) {
      if ($notes = $this->extractNotes($docComment)) {
        $metadata['notes'] = $notes;
      }

      // Extract @name
      if (preg_match('/@name\s+([^\n]+)/', $docComment, $matches)) {
        $metadata['name'] = trim($matches[1]);
      }
    }

    return $metadata;
  }

  /**
   * Extract notes from method docblock
   *
   * @param string $phpdoc
   * @return string|null
   */
  private function extractNotes($phpdoc)
  {
    // Match everything between @notes and either the next @ tag or the end of comment
    $pattern = '/@notes(.*?)(?=\s*\*\s*@|\s*\*\/)/s';

    if (preg_match($pattern, $phpdoc, $matches)) {
      if (isset($matches[1])) {
        // Get the raw notes content
        $rawNotes = $matches[1];

        // Remove leading asterisks and whitespace from each line
        $lines = explode("\n", $rawNotes);
        $cleanedLines = [];

        foreach ($lines as $line) {
          // Remove leading asterisks and whitespace
          $cleanedLine = preg_replace('/^\s*\*\s*/', '', $line);
          $cleanedLines[] = trim($cleanedLine);
        }

        // Filter out empty lines and join with spaces
        $cleanedLines = array_filter($cleanedLines, function ($line) {
          return $line !== '';
        });

        return implode(' ', $cleanedLines);
      }
    }

    return null;
  }

  /**
   * Format method name for display
   *
   * @param string $methodName
   * @return string
   */
  protected function formatMethodName(string $methodName): string
  {
    return ucfirst(str_replace('_', ' ', $methodName));
  }

  /**
   * Get the source code for a preview method
   *
   * @param string $methodName
   * @return string
   */
  public function getPreviewSource(string $methodName): string
  {
    $reflectionMethod = new \ReflectionMethod($this, $methodName);
    $filename = $reflectionMethod->getFileName();
    $startLine = $reflectionMethod->getStartLine();
    $endLine = $reflectionMethod->getEndLine();

    $file = file($filename);
    $source = implode("", array_slice($file, $startLine - 1, $endLine - $startLine + 1));

    // Extract Blade markup from Blade::render calls
    if (preg_match('/Blade::render\s*\(\s*<<<[\'"](?:HTML|BLADE)[\'"]\R(.*?)\R\s*(?:HTML|BLADE)/s', $source, $matches)) {
      return trim($matches[1]);
    }

    // Clean up the source code
    $source = preg_replace('/^\s{4}/', '', $source);

    return $source;
  }
}

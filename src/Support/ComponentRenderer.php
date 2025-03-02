<?php

namespace LaravelLookbook\Support;

use Illuminate\Support\Facades\Log;

class ComponentRenderer
{
    /**
     * Render a component preview
     *
     * @param array $component
     * @param string|null $method
     * @return string|array
     */
    public function render($component, $method = null)
    {
        if (!$component || !isset($component['file']) || !file_exists($component['file'])) {
            return 'Component not found';
        }

        try {
            require_once $component['file'];

            if (class_exists($component['class'])) {
                $previewClass = new $component['class']();

                if ($method && method_exists($previewClass, $method)) {
                    // Render specific method
                    return [
                        'method' => $method,
                        'output' => $previewClass->$method(),
                        'metadata' => $previewClass->getPreviewMetadata($method),
                        'source' => $previewClass->getPreviewSource($method)
                    ];
                } else {
                    // Render all preview methods
                    $previews = [];

                    foreach ($previewClass->getPreviews() as $previewMethod) {
                        $metadata = $previewClass->getPreviewMetadata($previewMethod);

                        // Skip hidden previews
                        if ($metadata['hidden']) {
                            continue;
                        }

                        $previews[] = [
                            'method' => $previewMethod,
                            'output' => $previewClass->$previewMethod(),
                            'metadata' => $metadata,
                            'source' => $previewClass->getPreviewSource($previewMethod)
                        ];
                    }

                    return $previews;
                }
            }

            return 'Invalid component preview class';
        } catch (\Exception $e) {
            $message = 'Error rendering component: ' . $e->getMessage();
            Log::error($message);
            return $message;
        }
    }

    /**
     * Get source code for a component preview method
     *
     * @param array $component
     * @param string $method
     * @return string
     */
    public function getSourceCode($component, $method)
    {
        if (!$component || !isset($component['file']) || !file_exists($component['file'])) {
            return 'Component source not found';
        }

        try {
            require_once $component['file'];

            if (class_exists($component['class'])) {
                $previewClass = new $component['class']();

                if (method_exists($previewClass, $method)) {
                    return $previewClass->getPreviewSource($method);
                }
            }

            return 'Preview method not found';
        } catch (\Exception $e) {
            return 'Error getting source code: ' . $e->getMessage();
        }
    }

    /**
     * Get notes for a component preview method
     *
     * @param array $component
     * @param string $method
     * @return string|null
     */
    public function getNotes($component, $method)
    {
        if (!$component) {
            return null;
        }

        try {
            require_once $component['file'];

            if (class_exists($component['class'])) {
                $previewClass = new $component['class']();

                if (method_exists($previewClass, $method)) {
                    $metadata = $previewClass->getPreviewMetadata($method);
                    return $metadata['notes'];
                }
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

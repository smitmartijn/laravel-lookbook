<?php

namespace LaravelLookbook\Models;

class Component
{
    protected $name;
    protected $preview;
    protected $sourceCode;
    protected $notes;

    public function __construct($name, $preview, $sourceCode, $notes = '')
    {
        $this->name = $name;
        $this->preview = $preview;
        $this->sourceCode = $sourceCode;
        $this->notes = $notes;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPreview()
    {
        return $this->preview;
    }

    public function getSourceCode()
    {
        return $this->sourceCode;
    }

    public function getNotes()
    {
        return $this->notes;
    }
}
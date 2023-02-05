<?php

namespace Tivins\Assets;

class ClassList
{
    protected array $classes = [];

    public function setClasses(string ...$classes): static
    {
        $this->classes = $classes;
        return $this;
    }

    public function addClasses(string ...$classes): static
    {
        $this->classes = array_merge($this->classes, $classes);
        return $this;
    }
}
<?php

namespace Tivins\Assets;

class ClassList
{
    protected array $classes = [];

    public function __construct(string ...$classes)
    {
        $this->classes = $classes;
    }

    public function empty(): bool
    {
        return empty($this->classes);
    }
    public function reset(): static
    {
        $this->classes = [];
        return $this;
    }

    public function set(string ...$classes): static
    {
        $this->classes = $classes;
        return $this;
    }

    public function add(string ...$classes): static
    {
        $this->classes = array_filter(array_unique(array_merge($this->classes, $classes)));
        return $this;
    }

    public function remove(string ...$classes): static
    {
        $this->classes = array_diff($this->classes, $classes);
        return $this;
    }

    public function __toString(): string
    {
        return join(' ', $this->classes);
    }
}
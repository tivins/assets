<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\Str;
use Tivins\Core\StrUtil;

class Button
{
    private Str    $label;
    private string $title  = '';
    private string $url  = '';
    private ?Icon  $icon = null;
    /** @var string[] */
    private array $classes = [];
    /** @var array<string,string> */
    private array $dataAttrs = [];

    public function __toString(): string
    {
        $tag   = $this->url ? 'a' : 'button';
        $attrs = '';
        if ($this->url) {
            $attrs .= ' href="' . $this->url . '"';
        }
        if ($this->title) {
            $attrs .= ' title="' . StrUtil::html($this->title) . '"';
        }
        $attrs .= ' class="' . join(' ', $this->classes) . '"';
        foreach ($this->dataAttrs as $key => $value) {
            $attrs .= ' data-' . $key . '="' . StrUtil::html($value) . '"';
        }
        return "<$tag$attrs>$this->icon$this->label</$tag>";
    }

    public function setLabel(Str $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function setTitle(string $title): Button
    {
        $this->title = $title;
        return $this;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function setIcon(?Icon $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

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

    public function setDataAttr(string $name, string $value): static
    {
        $this->dataAttrs[$name] = $value;
        return $this;
    }

    // --------------------------------
    // Static predefined configurations
    // --------------------------------

    public static function newGhost(): static {
        return (new static())->setClasses('ghost');
    }
    public static function newLink(): static {
        return (new static())->setClasses('link');
    }
}
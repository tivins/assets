<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\ClassList;
use Tivins\Assets\HDirection;
use Tivins\Assets\Size;
use Tivins\Assets\Style;
use Tivins\Assets\Str;
use Tivins\Core\StrUtil;

class Button
{
    private string|Str $label = '';

    /**
     * @var string Title attribute
     */
    private string $title  = '';
    private string $url  = '';
    private ?Icon  $icon = null;
    private ClassList $classes;
    /** @var array<string,string> */
    private array $dataAttrs = [];
    private HDirection $dropDown = HDirection::None;
    private Style $style = Style::Default;
    private Size $size = Size::MD;
    private bool $active = false;
    private bool $disabled = false;

    public function __construct()
    {
        $this->classes = new ClassList();
    }

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
        $classes = clone $this->classes;
        if ($this->url) {
            $classes->add('button');
        }
        if ($this->style != Style::Default) {
            $classes->add($this->style->value);
        }
        if ($this->size != Size::MD) {
            $classes->add($this->size->value);
        }
        if ($this->active) {
            $classes->add('active');
        }
        if ($this->disabled) {
            if ($this->url) {
                $classes->add('disabled');
            }
            else {
                $attrs .= ' disabled';
            }
        }
        if (! $classes->empty()) {
            $attrs .= ' class="' . $classes . '"';
        }
        foreach ($this->dataAttrs as $key => $value) {
            $attrs .= ' data-' . $key . '="' . StrUtil::html($value) . '"';
        }
        //<i class='ml-1 fs-80 muted-2 fa fa-angle-down'></i>
        $dd = '';
        if ($this->dropDown != HDirection::None) {
            $dd = new Icon('caret-' . ($this->dropDown->value>0?'up':'down'),margin: 'none', classes: ['ml-1' ,'fs-80 muted-2']);
        }
        return "<$tag$attrs>$this->icon$this->label$dd</$tag>";
    }

    public function setLabel(Str|string $label): static
    {
        $this->label = is_string($label) ? StrUtil::html($label) : $label;
        return $this;
    }

    /**
     * Set title attribute
     */
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

    public function getClassList(): ClassList {
        return $this->classes;
    }
    public function setClassList(ClassList $classList): static {
        $this->classes = $classList;
        return $this;
    }
    public function setClasses(string ...$classes): static
    {
        $this->classes->reset()->set(...$classes);
        return $this;
    }

    public function addClasses(string ...$classes): static
    {
        $this->classes->add(...$classes);
        return $this;
    }

    public function setDataAttr(string $name, string $value): static
    {
        $this->dataAttrs[$name] = $value;
        return $this;
    }

    public function setDropDir(HDirection $direction): static
    {
        $this->dropDown = $direction;
        return $this;
    }
    public function setStyle(Style $style): static {
        $this->style = $style;
        return $this;
    }
    public function setSize(Size $size): static {
        $this->size = $size;
        return $this;
    }
    public function setActive(bool $active): static {
        $this->active = $active;
        return $this;
    }
    public function setDisabled(bool $disabled): static {
        $this->disabled = $disabled;
        return $this;
    }
    // --------------------------------
    // Static predefined configurations
    // --------------------------------

    public static function new(): static {
        return (new static());
    }
    public static function newGhost(): static {
        return (new static())->setClasses('ghost');
    }
    public static function newLink(): static {
        return (new static())->setClasses('link');
    }
}
<?php

namespace Tivins\Assets\Components;

use Tivins\Assets\ClassList;
use Tivins\Assets\HDirection;
use Tivins\Assets\Size;
use Tivins\Assets\Style;
use Tivins\Assets\Str;
use Tivins\Core\StrUtil;

/**
 * Button is a fluent class component used to build many buttons.
 *
 * ```php
 * # Example
 * echo Button::new()
 *    ->setLabel('Button')
 *    ->setType(ButtonType::Ghost)
 *    ->setStyle(Style::Danger)
 *    ->setActive(true)
 *    ->setIcon(new Icon('lemon', 'regular'))
 *    ->setDisabled(true);
 * ```
 */
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
    private ButtonType $type = ButtonType::Default;

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
        $classes->add($this->type->value);
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
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Assign or remove the icon of this button.
     */
    public function setIcon(?Icon $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function getClassList(): ClassList {
        return $this->classes;
    }

    /**
     * Replace the current ClassList by the given one.
     */
    public function setClassList(ClassList $classList): static {
        $this->classes = $classList;
        return $this;
    }

    /**
     * Reset the current classList and fill with given ones.
     */
    public function setClasses(string ...$classes): static
    {
        $this->classes->reset()->set(...$classes);
        return $this;
    }

    /**
     * Add given classes to the current classList.
     */
    public function addClasses(string ...$classes): static
    {
        $this->classes->add(...$classes);
        return $this;
    }

    /**
     * Add a `data-` attribute in the HTML element.
     * @param string $name The data-attribute name (eg: 'target' will make a 'data-target' attribute).
     * @param string $value The value for the HTML attribute.
     * @return $this
     */
    public function setDataAttr(string $name, string $value): static
    {
        $this->dataAttrs[$name] = $value;
        return $this;
    }

    /**
     * Add a caret to the button.
     * @param HDirection $direction To remove the caret, use HDirection::None.
     */
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
    public function setType(ButtonType $type): static {
        $this->type = $type;
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

    /** Create a new Button. */
    public static function new(): static {
        return (new static());
    }
    /** Create a new Ghost Button. */
    public static function newGhost(): static {
        return (new static())->setType(ButtonType::Ghost);
    }
    /** Create a new Link Button. */
    public static function newLink(): static {
        return (new static())->setType(ButtonType::Link);
    }
}